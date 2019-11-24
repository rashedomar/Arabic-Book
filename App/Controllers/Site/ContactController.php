<?php
namespace App\Controllers\Site;
use Core\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('اتصل بنا');

        $data['recaptcha'] = $this->get('recaptcha')->widget();
        $data['success'] = $this->get('session')->has('success') ? $this->get('session')->pull('success') : null;
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('site/contact', $data);

        return $this->get('siteLayout')->render($view);
    }

    public function submit()
    {
        $json = [];
        $recaptcha = $this->get('recaptcha');
        if ($recaptcha->response()) {
            if ($this->isValid()) {
                if ($this->get('token')->check($this->get('request')->post('token'))) {
                    $this->get('load')->model('Contacts')->create();
                    $this->get('session')->set('success', 'تم إرسال رسالتك بنجاح.');
                    $json['success'] = 'تمت الإرسال بنجاح!';
                    $json['redirect'] = url('/contact');
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
        $this->get('valid')->required('name', 'الاسم مطلوب');
        $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email');
        $this->get('valid')->required('title', 'عنوان الرسالة مطلوب');
        $this->get('valid')->required('message', 'نص الرسالة مطلوب');
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }
}

?>
