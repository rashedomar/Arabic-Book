<?php

namespace App\Controllers\Admin;

use Core\Controller;

class CommentsController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle('التعليقات');

        $data['comments'] = $this->get('load')->model('Comments')->all();
        $data['url'] = url('/admin/comments?page=');
        $data['pagination'] = $this->get('pagination')->paginate();
        $data['token'] = $this->get('token')->generate();

        $view = $this->get('view')->render('admin/comments/list', $data);

        return $this->get('adminLayout')->render($view);
    }

    public function edit($id)
    {

        $CommentsModel = $this->get('load')->model('Comments');
        if (! $CommentsModel->exists($id)) {
            return redirectTo('/404');
        }
        $comment = $CommentsModel->getID($id);
        $data['target'] = 'edit-comment-'.$comment->id;
        $data['action'] = url('/admin/comments/save/'.$comment->id);
        $data['heading'] = 'تعديل التعليق';
        $data['comment'] = $comment->comment;
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/comments/modal', $data);
    }

    public function delete($id)
    {
        if ($this->get('token')->check($this->get('request')->post('token'))) {
            $CategoriesModel = $this->get('load')->model('Comments');
            if (! $CategoriesModel->exists($id)) {
                return redirectTo('/404');
            }
            $CategoriesModel->delete($id);

            $json['success'] = 'تم حذف التعليق';

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
                $this->get('load')->model('Comments')->update($id);
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
        $this->get('valid')->required('comment', 'التعليق مطلوب');
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }
}