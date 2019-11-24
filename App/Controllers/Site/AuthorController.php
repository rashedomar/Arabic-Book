<?php

namespace App\Controllers\Site;

use Core\Controller;

class AuthorController extends Controller
{
    public function index($name, $id)
    {

        $author = $this->get('load')->model('Authors')->getAuthorWithBooks($id);
        if (! $author) {
            return redirectTo('/404');
        }
        $this->get('html')->setTitle($author->name);

        $data['author'] = $author;
        $data['url'] = url('/author/'.seo($author->name).'/'.$author->id.'?page=');
        $data['pagination'] = $this->get('pagination')->paginate();

        $view = $this->get('view')->render('site/author', $data);

        return $this->get('siteLayout')->render($view);
    }
}