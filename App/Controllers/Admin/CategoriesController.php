<?php

namespace App\Controllers\Admin;

use Core\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('التصنيفات');

        $data['categories'] = $this->get('load')->model('Categories')->all();
        $data['url'] = url('/admin/categories?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('admin/categories/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function add()
    {
        $this->get('html')->setTitle('إضافة تصنيف');

        $data['categories'] = $this->get('load')->model('Categories')->allWithSubCategories();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/categories/add', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function edit($id)
    {

        $CategoriesModel = $this->get('load')->model('Categories');
        if (! $CategoriesModel->exists($id)) {
            return redirectTo('/404');
        }
        $data['categories'] = $this->get('load')->model('Categories')->allWithSubCategories();
        $category = $CategoriesModel->getID($id);
        $data['target'] = 'edit-category-'.$category->id;
        $data['action'] = url('/admin/categories/save/'.$category->id);
        $data['heading'] = 'تعديل';
        $data['category'] = $category;
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/categories/modal', $data);
    }

    public function submit()
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Categories')->create();
                $json['redirect'] = url('/admin/categories');
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
        $this->get('valid')->required('name', 'اسم التصنيف مطلوب!');
        $this->get('valid')->required('pid', 'التصنيف الأب مطلوب!');
        $this->get('valid')->required('status', 'حالة التصنيف مطلوبة!');
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    public function delete($id)
    {
        if ($this->get('token')->check($this->get('request')->post('token'))) {
            $CategoriesModel = $this->get('load')->model('Categories');
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

    public function save($id)
    {
        $json = [];

        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Categories')->update($id);
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