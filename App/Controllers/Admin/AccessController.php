<?php
namespace App\Controllers\Admin;
use Core\Controller;

class AccessController extends Controller
{
    public function index()
    {

        $ignoredPages = ['/admin/login', '/admin/login/submit'];

        $loginModel = $this->get('load')->model('Login');
        $logged = ! is_null($loginModel->user()) ? true : false;
        $currentPage = $this->get('request')->getUrl();

        if (($NotLogged = ! $logged) AND ! in_array($currentPage, $ignoredPages)) {
            return redirectTo('/admin/login');
        }

        if ($NotLogged AND in_array($currentPage, $ignoredPages)) {
            return false;
        }

        if (! $NotLogged) {
            $UsersGroupsModel = $this->get('load')->model('UsersGroups');
            $UsersGroup = $UsersGroupsModel->getID($loginModel->user()->user_group_id);
            if (! $UsersGroup AND is_null($UsersGroup)) {
                return redirectTo('/');
            }
            $currentPage = preg_replace('#(\d+)#', ':id', $currentPage);

            if (! in_array($currentPage, $UsersGroup->pages) AND ! is_null($UsersGroup)) {
                return redirectTo('/404');
            }
        }
    }
}

?>
