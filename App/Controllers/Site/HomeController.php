<?php

namespace App\Controllers\Site;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->get('html')->setTitle($this->get('settings')['name']);

        $data['LatestBooks'] = $this->get('load')->model('Books')->getBY(7, 'id');
        $data['MostPopularWeek'] = $this->get('load')->model('Books')->getBY(7, 'page_count');
        $data['MostDownWeek'] = $this->get('load')->model('Books')->getBY(7, 'downloads');
        $data['categories'] = $this->get('load')->model('Categories')->getPopularParentCatsOnly(7);
        $user = $this->get('load')->model('Login')->user();

        if ($this->get('settings')['status'] === 'disabled') {
            $sett['close_msg'] = $this->get('settings')['close_msg'];
            $view = $this->get('view')->render('site/lock', $sett);
        } elseif ($user AND $user->status === 'disabled') {
            $sett['disabledMsg'] = 'حسابك مُعطل .. يجب عليك تفعيله لتتمكن من تصفح الموقع';
            $view = $this->get('view')->render('site/lock', $sett);
        } else {
            $view = $this->get('view')->render('site/home', $data);
        }

        return $this->get('siteLayout')->render($view);
    }
}
