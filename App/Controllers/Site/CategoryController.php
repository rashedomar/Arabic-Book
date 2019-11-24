<?php

namespace App\Controllers\Site;

use Core\Controller;

class CategoryController extends Controller
{
    public function index($title, $id)
    {

        $category = $this->get('load')->model('Categories')->getCategoryWithBooks($id);

        if (! $category) {
            return redirectTo('/404');
        }

        $this->get('html')->setTitle($category->name);

        $data['category'] = $category;
        $data['childes'] = $this->get('load')->model('Categories')->getChildCats($id);
        $data['url'] = url('/category/'.seo($category->name).'/'.$category->id.'?page=');
        $data['pagination'] = $this->get('pagination')->paginate();

        $view = $this->get('view')->render('site/category', $data);

        return $this->get('siteLayout')->render($view);
    }
}
