<?php

namespace App\Controllers\Admin;

use Core\Controller;

class LoginController extends Controller
{
    public function index()
    {
        //TODO Cookies
        $loginModel = $this->get('load')->model('login');
        if ($loginModel->isLogged()) {
            redirectTo('/admin');
        }
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/login', $data);
    }

    public function submit()
    {

        $json = [];
        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                if ($this->exists($this->get('request')->post('email'), $this->get('request')->post('password'))) {
                    $loginModel = $this->get('load')->model('Login');

                    $this->get('session')->set('login', $loginModel->user()->code);

                    $json['success'] = 'مرحباً بعودتك '.$loginModel->user()->first_name;
                    $json['redirect'] = url('/admin');

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

    private function isValid()
    {

        $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email');
        $this->get('valid')->required('password', 'كلمة المرور مطلوبة');
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
}