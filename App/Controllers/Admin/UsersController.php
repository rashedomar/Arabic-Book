<?php

namespace App\Controllers\Admin;

use Core\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('المجموعات');

        $data['users'] = $this->get('load')->model('Users')->all();
        $data['url'] = url('/admin/users?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/users/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function add()
    {
        $this->get('html')->setTitle('إضافة مستخدم');

        $data['usersGroups'] = $this->get('load')->model('UsersGroups')->all();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/users/add', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function edit($id)
    {

        $UsersModal = $this->get('load')->model('Users');
        if (! $UsersModal->exists($id)) {
            return redirectTo('/404');
        }

        $user = $UsersModal->getID($id);

        $data['target'] = 'edit-users-'.$user->id;
        $data['action'] = url('/admin/users/save/'.$user->id);
        $data['heading'] = 'تعديل';
        $data['name'] = $user->first_name.' '.$user->last_name;
        $data['user'] = $user;
        $data['users_groups'] = $this->get('load')->model('UsersGroups')->all();
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/users/modal', $data);
    }

    public function save($id)
    {
        $json = [];
        if ($this->isValid($id)) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Users')->update($id);
                $json['redirect'] = url('/admin/users-groups');
                $json['success'] = 'تم التحديث بنجاح!';
            } else {
                return redirectTo('/404');
            }
        } else {
            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }

    private function isValid($id = null)
    {

        $this->get('valid')->required('first-name', 'الاسم الأول مطلوب');
        $this->get('valid')->required('last-name', 'الاسم الأخير مطلوب');
        $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email');
        $this->get('valid')->required('token');
        if (is_null($id)) {

            $this->get('valid')->unique('email', ['users', 'email'], 'البريد الإلكتروني مستخدم من قبل شخص آخر');
            $this->get('valid')->image('image', 'امتداد الصورة غير صحيح');
            $this->get('valid')->required('password', 'كلمة المرور مطلوبة')->minLength('password', 8, 'كلمة المرور يجب أن تكون على الأقل 8 أحرف')->maxLength('password', 30, 'كلمة المرور يجب أن تكون على الأكثر 30 حرف')->match('password', 'confirm-password', 'كلمتي المرور يجب ان تكونا متطابقتان');
        } else {
            $this->get('valid')->image('image', 'امتداد الصورة غير صحيح');
            $this->get('valid')->unique('email', ['users', 'email', 'id', $id]);
        }

        $this->get('valid')->required('status', 'الحالة مطلوبة')->expectedValues('status', ['enabled', 'disabled',]);
        $this->get('valid')->required('users-group-id', 'مجموعة المستخدم مطلوبة')->isInt('users-group-id');

        return $this->get('valid')->passes();
    }

    public function submit()
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Users')->create();
                $json['redirect'] = url('/admin/users');
                $json['success'] = 'تمت الإضافة بنجاح';
            } else {
                return redirectTo('/404');
            }
        } else {
            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }

    public function delete($id)
    {
        if ($this->get('token')->check($this->get('request')->post('token'))) {
            $usersModel = $this->get('load')->model('Users');
            if (! $usersModel->exists($id)) {
                return redirectTo('/404');
            }
            $usersModel->delete($id);

            $json['success'] = 'تم حذف المستخدم';

            return $this->json($json);
        } else {
            return redirectTo('/404');
        }
    }
}