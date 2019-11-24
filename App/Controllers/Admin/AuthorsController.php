<?php

namespace App\Controllers\Admin;

use Core\Controller;

class AuthorsController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('المؤلفين');

        $data['authors'] = $this->get('load')->model('Authors')->all();
        $data['url'] = url('/admin/authors?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/authors/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function add()
    {
        $this->get('html')->setTitle('إضافة مؤلف');
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/authors/add', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function edit($id)
    {

        $AuthorsModel = $this->get('load')->model('Authors');
        if (! $AuthorsModel->exists($id)) {
            return redirectTo('/404');
        }

        $author = $AuthorsModel->getID($id);

        $data['target'] = 'edit-author-'.$author->id;
        $data['action'] = url('/admin/authors/save/'.$author->id);
        $data['heading'] = 'تعديل';
        $data['author'] = $author;
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/authors/modal', $data);
    }

    public function submit()
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Authors')->create();
                $json['redirect'] = url('/admin/authors');
                $json['success'] = 'تمت الإضافة بنجاح';
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
        $this->get('valid')->required('name', 'اسم المؤلف مطلوب!');
        $this->get('valid')->image('image', 'امتداد الصورة غير صحيح');
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    public function delete($id)
    {
        if ($this->get('token')->check($this->get('request')->post('token'))) {
            $AuthorsModel = $this->get('load')->model('Authors');
            if (! $AuthorsModel->exists($id)) {
                return redirectTo('/404');
            }
            $AuthorsModel->delete($id);

            $json['success'] = 'تم حذف المؤلف';

            return $this->json($json);
        } else {
            return redirectTo('/404');
        }
    }

    public function save($id)
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Authors')->update($id);
                $json['success'] = 'تم التحديث بنجاح!';
            } else {
                return redirectTo('/404');
            }
        } else {
            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }
}