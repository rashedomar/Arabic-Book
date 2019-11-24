<?php
namespace App\Controllers\Site;
use Core\Controller;

class LoginController extends Controller
{
    public function submit()
    {

        $json = [];
        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                if ($this->exists($this->get('request')->post('email'), $this->get('request')->post('password'))) {
                    $loginModel = $this->get('load')->model('Login');

                    $this->get('session')->set('login', $loginModel->user()->code);

                    $json['success'] = 'مرحباً بعودتك '.$loginModel->user()->first_name;
                    $json['redirect'] = url('/');

                    return $this->json($json);
                } else {
                    $json['errors'] = 'بيانات الدخول خاطئة!';
                }
            } else {
                return redirectTo('/404');
            }
        } else {

            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }

    private function isValid($lostPw = false, $newPw = false)
    {
        if ($lostPw) {
            $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email');
        } elseif ($newPw) {
            $this->get('valid')->required('code');
            $this->get('valid')->required('password', 'كلمة المرور مطلوبة')->minLength('password', 8, 'كلمة المرور يجب أن تكون على الأقل 8 أحرف')->maxLength('password', 30, 'كلمة المرور يجب أن تكون على الأكثر 30 حرف')->match('password', 'confirm-password', 'كلمتي المرور يجب ان تكونا متطابقتان');
        } else {
            $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email');
            $this->get('valid')->required('password', 'كلمة المرور مطلوبة');
        }
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    private function exists($email, $pass)
    {
        $loginModel = $this->get('load')->model('Login');
        if (! $loginModel->isValidLogin($email, $pass)) {
            return false;
        } else {
            return true;
        }
    }

    public function lostPw()
    {
        $loginModel = $this->get('load')->model('Login');
        if ($loginModel->isLogged()) {
            return redirectTo('/');
        }
        $this->get('html')->setTitle('استعادة كلمة المرور');
        $data['recaptcha'] = $this->get('recaptcha')->widget();
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('site/lostpw', $data);

        return $this->get('siteLayout')->render($view);
    }

    public function lostPwSubmit()
    {
        $json = [];
        $recaptcha = $this->get('recaptcha');
        if ($recaptcha->response()) {
            if ($this->isValid(true)) {
                if ($this->get('token')->check($this->get('request')->post('token'))) {
                    $usersModel = $this->get('load')->model('Users');
                    $email = $usersModel->exists($this->get('request')->post('email'), 'email');
                    if (! $email OR is_null($email)) {
                        $json['errors'] = 'هذا البريد الإلكتروني غير موجود!';
                    } else {
                        $resetKey = generateRandom(21);
                        $usersModel->resetCode($resetKey);
                        if ($this->sendEmail($this->get('request')->post('email'), $resetKey)) {
                            $json['success'] = 'تم إرسال رابط استعادة كلمة المرور على بريدك الإلكتروني.';
                        } else {
                            $json['errors'] = 'حدث خطأ في الإرسال لهذا البريد الإلكتروني.';
                        }
                    }
                } else {
                    return redirectTo('/404');
                }
            } else {
                $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
            }
        } else {
            $json['errors'] = 'فشل في التحقق البشري';
        }

        return $this->json($json);
    }

    private function sendEmail($email, $resetKey)
    {
        $mail = $this->get('mail');
        $resetLink = url('/newpw/'.$resetKey);
        $message = ' استعادة كلمة المرور لـ : '.$email.'<br>';
        $message .= 'اضغط على الرابط التالي لإنشاء كلمة مرور جديدة خاصة بحسابك: <br>';
        $message .= '<a href="'.$resetLink.'">'.$resetLink.'</a>';
        $subject = '  استعادة كلمة المرور ';

        return $mail->sendMail($email, $subject, $message);
    }

    public function newPwSubmit()
    {
        $json = [];

        if ($this->isValid(false, true)) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $usersModel = $this->get('load')->model('Users');
                $usersModel->newPw();
                $json['success'] = 'تم تحديث كلمة المرور الخاصة بك';
            } else {
                return redirectTo('/404');
            }
        } else {
            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }

    public function newPw($key)
    {

        $loginModel = $this->get('load')->model('Login');
        if ($loginModel->isLogged()) {
            return redirectTo('/');
        }
        $usersModel = $this->get('load')->model('Users');
        $code = $usersModel->exists($key, 'code');
        if (! $code) {
            return redirectTo('/');
        }
        $this->get('html')->setTitle('إنشاء كلمة مرور جديدة');
        $data['token'] = $this->get('token')->generate();
        $data['code'] = $key;
        $view = $this->get('view')->render('site/newpw', $data);

        return $this->get('siteLayout')->render($view);
    }
}

?>
