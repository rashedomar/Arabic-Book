<?php

namespace Core;

/**
 * Class View
 *
 * @package Core
 */
class View implements IView
{
    /**
     * data
     *
     * @var array $data
     */
    private $data = [];

    /**
     * view Path
     *
     * @var string $viewPath
     */
    private $viewPath;

    /**
     * output
     *
     * @var string $output
     */
    private $output;

    public function __construct($viewPath, array $data = [])
    {
        $this->data = $data;
        $this->setViewPath($viewPath);
    }

    /**
     * Generate the full path for the view path
     *
     * @param String $viewPath
     * @throws \Exception
     * @return void
     */
    private function setViewPath($viewPath)
    {
        if (in_array('newInstall', $this->data)) {
            $ViewPath = ROOT.'/'.APP_DIR.'/Install/'.$viewPath.'.php';
        } else {
            $ViewPath = ROOT.'/'.APP_DIR.'/App/Views/'.$viewPath.'.php';
        }
        if (! $this->viewFileExists($ViewPath)) {
            throw new \Exception(' {{ '.$viewPath.' }}  does not exists');
        }
        $this->viewPath = $ViewPath;
    }

    /**
     * Determine if the view path exists in the view directory
     *
     * @param string $viewPath
     * @return bool
     */
    private function viewFileExists($viewPath)
    {
        return file_exists($viewPath);
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->getOutput();
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        if (is_null($this->output)) {
            ob_start();
            extract($this->data);
            require $this->viewPath;
            $this->output = ob_get_clean();
        }

        return $this->output;
    }
}