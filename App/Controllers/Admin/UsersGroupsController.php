<?php

namespace App\Controllers\Admin;

use Core\Controller;

class UsersGroupsController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('المجموعات');

        $data['usersGroups'] = $this->get('load')->model('UsersGroups')->all();
        $data['url'] = url('/admin/users-groups?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/users-groups/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function add()
    {
        $this->get('html')->setTitle('إضافة مجموعة');

        $data['pages'] = $this->getPrivilegesPages();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/users-groups/add', $data);

        return $this->get('adminLayout')->render($view);
    }

    private function getPrivilegesPages()
    {
        $privileges = [];
        foreach ($this->get('route')->getRoutes() as $route) {
            if (strpos($route['prettyURL'], '/admin') === 0) {
                $desc = $route['desc'] == null ? $route['prettyURL'] : $route['desc'];
                list ($prettyURL, $desc) = explode('|', $route['prettyURL'].'|'.$desc);
                $url['prettyURL'] = $prettyURL;
                $url['desc'] = $desc;
                $privileges[] = $url;
            }
        }

        return $privileges;
    }

    public function edit($id)
    {

        $UsersGroupsModal = $this->get('load')->model('UsersGroups');
        if (! $UsersGroupsModal->exists($id) OR $id == 1 OR $id == 2) {
            return redirectTo('/404');
        }

        $userGroupId = $UsersGroupsModal->getID($id);
        $data['target'] = 'edit-users-groups-'.$userGroupId->id;
        $data['action'] = url('/admin/users-groups/save/'.$userGroupId->id);
        $data['heading'] = 'تعديل';
        $data['name'] = $userGroupId->name;
        $data['pages'] = $this->getPrivilegesPages();
        $data['users_groups_pages'] = $userGroupId->pages;
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/users-groups/modal', $data);
    }

    public function save($id)
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('UsersGroups')->update($id);
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

    private function isValid()
    {
        $this->get('valid')->required('name', 'اسم المجموعة مطلوب');
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    public function submit()
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('UsersGroups')->create();
                $json['redirect'] = url('/admin/users-groups');
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
            $CategoriesModel = $this->get('load')->model('UsersGroups');
            if (! $CategoriesModel->exists($id)) {
                return redirectTo('/404');
            }
            $CategoriesModel->delete($id);

            $json['success'] = 'تم حذف التصنيف';

            return $this->json($json);
        } else {
            return redirectTo('/404');
        }
    }
}