<?php

namespace App\Controllers\Admin;

use Core\Controller;

class ContactsController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('الرسائل');

        $data['messages'] = $this->get('load')->model('Contacts')->all();
        $data['url'] = url('/admin/contacts?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/contacts/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function show($id)
    {
        $ContactsModel = $this->get('load')->model('Contacts');
        if (! $ContactsModel->exists($id)) {
            return redirectTo('/404');
        }
        $ContactsModel->update($id);
        $contactId = $ContactsModel->getID($id);
        $this->get('html')->setTitle('قراءة الرسالة:'.$contactId->title);
        $data['message'] = $contactId;
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('admin/contacts/show', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function submit($id)
    {
        $json = [];
        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $ContactsModel = $this->get('load')->model('Contacts');
                $replyTo = $ContactsModel->getID($id);
                if ($this->sendEmail($replyTo->email, $replyTo->name)) {
                    $ContactsModel->update($id, true);
                } else {
                    $json['error'] = 'خطأ في إرسال الرد';
                }
                $json['redirect'] = url('/admin/contacts/show/'.$id);
                $json['success'] = 'تم الرد بنجاح';
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
        $this->get('valid')->required('reply', 'الرد مطلوب');
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    private function sendEmail($email, $name)
    {
        $mail = $this->get('mail');
        $subject = 'الرد على رسالتك يا '.$name;
        $reply = $this->get('request')->post('reply');

        return $mail->sendMail($email, $subject, $reply);
    }

    public function delete($id)
    {
        if ($this->get('token')->check($this->get('request')->post('token'))) {
            $ContactsModel = $this->get('load')->model('Contacts');
            if (! $ContactsModel->exists($id)) {
                return redirectTo('/404');
            }
            $ContactsModel->delete($id);

            $json['success'] = 'تم حذف الرسالة';

            return $this->json($json);
        } else {
            return redirectTo('/404');
        }
    }
}