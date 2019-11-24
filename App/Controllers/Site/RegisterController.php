<?php
namespace App\Controllers\Site;
use Core\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        $loginModel = $this->get('load')->model('Login');
        if ($loginModel->isLogged()) {
            return redirectTo('/');
        }
        $data['can_register'] = $this->get('settings')['can_register'];
        $this->get('html')->setTitle('إنشاء حساب جديد');
        $data['recaptcha'] = $this->get('recaptcha')->widget();
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('site/register', $data);

        return $this->get('siteLayout')->render($view);
    }

    public function submit()
    {
        $json = [];
        $recaptcha = $this->get('recaptcha');
        if ($recaptcha->response()) {
            if ($this->isValid()) {
                if ($this->get('token')->check($this->get('request')->post('token'))) {
                    $email_activation_key = generateRandom(31);
                    if ($this->sendEmail($this->get('request')->post('email'), $this->get('request')->post('first-name'), $email_activation_key)) {
                        $defaultGroup = $this->get('settings')['default_users_group'];
                        $this->get('load')->model('Users')->create($defaultGroup, $email_activation_key);
                        $json['success'] = 'تم إرسال رسالة تفعيل حسابك على البريد الإلكتروني الخاص بك.. يرجى الضغط على رابط التفعيل الموجود بالرسالة المُرسلة.';
                    } else {
                        $json['errors'] = 'حدث خطأ في الإرسال لهذا البريد الإلكتروني.';
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

    private function isValid()
    {
        $this->get('valid')->required('first-name', 'الاسم الأول مطلوب');
        $this->get('valid')->required('last-name', 'الاسم الأخير مطلوب');
        $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email')->unique('email', [
            'users',
            'email',
        ], 'البريد الإلكتروني مستخدم من قبل شخص آخر');

        $this->get('valid')->required('password', 'كلمة المرور مطلوبة')->minLength('password', 8, 'كلمة المرور يجب أن تكون على الأقل 8 أحرف')->maxLength('password', 30, 'كلمة المرور يجب أن تكون على الأكثر 30 حرف')->match('password', 'confirm-password', 'كلمتي المرور يجب ان تكونا متطابقتان');

        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    private function sendEmail($email, $first_name, $email_activation_key)
    {
        $mail = $this->get('mail');
        $activationLink = url('/active/'.$email_activation_key);
        $message = ' السلام عليكم ، '.$first_name.'<br>';
        $message .= 'لتفعيل الحساب الخاص بك الرجاء الضغط على الرابط التالي <br>';
        $message .= '<a href="'.$activationLink.'">'.$activationLink.'</a>';
        $subject = ' تفعيل حسابك ';

        return $mail->sendMail($email, $subject, $message);
    }

    public function active($key)
    {

        if (! $key OR is_null($key) OR $key === '') {
            redirectTo('/404');
        }
        $usersModel = $this->get('load')->model('Users')->verify($key);
        if ($usersModel) {

            $this->get('html')->setTitle('تم تفعيل الحساب');

            $loginModel = $this->get('load')->model('Login');

            if ($this->container->has('LoggedUser')) {
                $data['user'] = $loginModel->user();
            } else {
                $data['user'] = null;
            }

            $view = $this->get('view')->render('site/verify');

            return $this->get('siteLayout')->render($view, $data);
        } else {
            redirectTo('/404');
        }
    }
}

?>
