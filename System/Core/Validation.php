<?php

namespace Core;

class Validation
{
    private $container;

    private $errors = [];

    public function __construct()
    {
        $this->container = App::getInstance();
    }

    /**
     * Check if empty
     *
     * @param      $inputName
     * @param null $CustomErrorMsg
     * @return Validation
     */
    public function required($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);
        if (empty($inputValue) OR is_null($inputValue) OR $inputValue == '') {
            $message = $CustomErrorMsg ?: sprintf('%s is required', $inputName);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    private function hasErrors($inputName)
    {
        return array_key_exists($inputName, $this->errors);
    }

    private function value($input)
    {
        return $this->container->get('request')->post($input);
    }

    private function addError($inputName, $message)
    {
        if (! array_key_exists($inputName, $this->errors)) {
            $this->errors[$inputName] = $message;
        }
    }

    public function email($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }
        $inputValue = $this->value($inputName);

        if (! filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
            $message = $CustomErrorMsg ?: sprintf(' تنسيق البريد الإلكتروني غير صحيح', $inputName);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    public function minLength($inputName, $length, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }
        $inputValue = mb_strlen($this->value($inputName), 'UTF-8');
        if ($inputValue < $length) {
            $message = $CustomErrorMsg ?: sprintf('%s يجب أن يكون على الأقل %d أحرف', $inputName, $length);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    public function maxLength($inputName, $length, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }
        $inputValue = mb_strlen($this->value($inputName), 'UTF-8');
        if ($inputValue > $length) {
            $message = $CustomErrorMsg ?: sprintf('%s يجب أن يكون على الأكثر %d حروف', $inputName, $length);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    public function match($firstInput, $SecondInput, $CustomErrorMsg = null)
    {
        $firstInputValue = $this->value($firstInput);
        $SecondInputValue = $this->value($SecondInput);
        if ($firstInputValue != $SecondInputValue) {
            $message = $CustomErrorMsg ?: sprintf('%s  يجب أن يكون مطابق لـ', $SecondInput);
            $this->addError($SecondInput, $message);
        }

        return $this;
    }

    public function unique($inputName, array $databaseData, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        $table = null;
        $column = null;
        $exceptionColumn = null;
        $exceptionColumnValue = null;

        if (count($databaseData) == 2) {
            list($table, $column) = $databaseData;
        } elseif (count($databaseData) == 4) {
            list($table, $column, $exceptionColumn, $exceptionColumnValue) = $databaseData;
        }

        if ($exceptionColumn && $exceptionColumnValue) {
            $result = $this->container->get('db')->select($column)->from($table)->where($column.'= ? AND '.$exceptionColumn.'!= ?', $inputValue, $exceptionColumnValue)->fetch();
        } else {
            $result = $this->container->get('db')->select($column)->from($table)->where($column.'= ?', $inputValue)->fetch();
        }
        if ($result) {
            $message = $CustomErrorMsg ?: sprintf('%s مستخدم من قبل شخص آخر', $inputName);
            $this->addError($inputName, $message);
        }
    }

    public function expectedValues($inputName, array $expectedValues, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if (! in_array($inputValue, $expectedValues)) {
            $message = $CustomErrorMsg ?: sprintf('%s قيمة غير متوقعة', $inputName);
            $this->addError($inputName, $message);
        }
    }

    public function isInt($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if (! filter_var($inputValue, FILTER_VALIDATE_INT)) {
            $message = $CustomErrorMsg ?: sprintf('%s قيمة غير متوقعة', $inputName);
            $this->addError($inputName, $message);
        }
    }

    public function isURL($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);
        if ($parts = parse_url($inputValue)) {
            if (! isset($parts["scheme"])) {
                $inputValue = "http://$inputValue";
            }
        }

        if (filter_var($inputValue, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === false) {
            $message = $CustomErrorMsg ?: sprintf('%s رابط غير صحيح', $inputName);
            $this->addError($inputName, $message);
        }
    }

    public function requiredFile($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $file = $this->container->get('request')->file($inputName);
        if (! $file->exists()) {
            $message = $CustomErrorMsg ?: sprintf($file->checkErrors(), $inputName);
            $this->addError($inputName, $message);
        }
        //        if (! $file->exists()) {
        //            $message = $CustomErrorMsg ?: sprintf('%s is required', $inputName);
        //            $this->addError($inputName, $message);
        //        }

        return $this;
    }

    public function image($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }
        $file = $this->container->get('request')->file($inputName);

        if (! $file->exists()) {
            return $this;
        }

        if (! $file->isImage()) {

            $message = $CustomErrorMsg ?: sprintf('%s is not valid image', $inputName);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    public function pdf($inputName, $CustomErrorMsg = null)
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }
        $file = $this->container->get('request')->file($inputName);

        if (! $file->exists()) {
            return $this;
        }

        if (! $file->isPDF()) {

            $message = $CustomErrorMsg ?: sprintf('%s is not valid file', $inputName);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    public function passes()
    {
        return empty($this->errors);
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }
}