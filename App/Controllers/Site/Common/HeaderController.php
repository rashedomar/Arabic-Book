<?php
namespace App\Controllers\Site\Common;
use Core\Controller;

class HeaderController extends Controller
{
    public function index()
    {
        $data['title'] = $this->get('html')->getTitle();
        $data['settings'] = (object) $this->get('settings');
        $loginModel = $this->get('load')->model('Login');
        if ($this->container->has('LoggedUser')) {
            $data['user'] = $loginModel->user();
        } else {
            $data['user'] = null;
        }
        $data['categories'] = $this->get('load')->model('Categories')->getParentCatsWithTotalBooks();
        $data['token'] = $this->get('token')->generate(false);

        return $this->get('view')->render('site/common/header', $data);
    }
}

?>
