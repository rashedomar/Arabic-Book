<?php

namespace App\Controllers\Admin;

use Core\Controller;

class BooksController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('الكتب');

        $data['books'] = $this->get('load')->model('Books')->all();
        $data['url'] = url('/admin/books?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/books/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function add()
    {

        $this->get('html')->setTitle('إضافة كتاب');

        $data['categories'] = $this->get('load')->model('Categories')->allWithSubCategories();
        $data['authors'] = $this->get('load')->model('Authors')->all();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/books/add', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function edit($id)
    {

        $BooksModel = $this->get('load')->model('Books');

        if (! $BooksModel->exists($id)) {
            return redirectTo('/404');
        }

        $data['categories'] = $this->get('load')->model('Categories')->allWithSubCategories();
        $data['authors'] = $this->get('load')->model('Authors')->all();
        $book = $BooksModel->getID($id, true);
        $data['target'] = 'edit-book-'.$book->id;
        $data['action'] = url('/admin/books/save/'.$book->id);
        $data['heading'] = 'تعديل';
        $data['id'] = $book->id;
        $data['book'] = $book;
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/books/modal', $data);
    }

    public function submit($addByUrl = false)
    {
        $json = [];

        if ($this->ByUrl()) {
            $addByUrl = true;
        }

        if ($this->isValid($id = null, $addByUrl)) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Books')->create($addByUrl);
                $json['redirect'] = url('/admin/books');
                $json['success'] = 'تمت الإضافة بنجاح';
            } else {
                return redirectTo('/404');
            }
        } else {
            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }

    private function ByUrl()
    {
        return (strpos($this->get('request')->getUrl(), '/url') !== false);
    }

    private function isValid($id = null, $addByUrl = false)
    {
        $this->get('valid')->required('title', 'عنوان الكتاب مطلوب');
        $this->get('valid')->required('category', 'تصنيف الكتاب مطلوب')->isInt('category');
        $this->get('valid')->required('author', 'مؤلف الكتاب مطلوب')->isInt('author');
        $this->get('valid')->required('status', 'الحالة مطلوبة')->expectedValues('status', ['enabled', 'disabled',]);
        $this->get('valid')->image('image', 'امتداد الصورة غير صحيح');
        $this->get('valid')->required('token');
        if (is_null($id)) {
            if ($addByUrl) {
                $this->get('valid')->required('link', 'الرابط الخارجي مطلوب')->isURL('link', 'الرابط غير صحيح');
            } else {
                $this->get('valid')->requiredFile('link')->pdf('link', 'امتداد الملف غير صحيح');
            }
        } else {
            if ($addByUrl) {
                $this->get('valid')->required('link', 'الرابط الخارجي مطلوب')->isURL('link', 'الرابط غير صحيح');
            } else {
                $this->get('valid')->pdf('link', 'امتداد الملف غير صحيح');
            }
        }

        return $this->get('valid')->passes();
    }

    public function delete($id)
    {
        if ($this->get('token')->check($this->get('request')->post('token'))) {
            $BooksModel = $this->get('load')->model('Books');
            if (! $BooksModel->exists($id)) {
                return redirectTo('/404');
            }
            $BooksModel->delete($id);

            $json['success'] = 'تم حذف الكتاب';

            return $this->json($json);
        } else {
            return redirectTo('/404');
        }
    }

    public function save($id, $addByUrl = false)
    {
        if ($this->ByUrl()) {
            $addByUrl = true;
        }
        $json = [];

        if ($this->isValid($id, $addByUrl)) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Books')->update($id, $addByUrl);
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