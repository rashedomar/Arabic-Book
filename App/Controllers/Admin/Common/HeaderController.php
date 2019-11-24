<?php
namespace App\Controllers\Admin\Common;
use Core\Controller;

class HeaderController extends Controller
{
    public function index()
    {
        $data['title'] = $this->get('html')->getTitle();
        $data['user'] = $this->get('LoggedUser');
        $data['unread'] = $this->get('load')->model('Contacts')->unread();
        $data['settings'] = (object) $this->get('settings');

        return $this->get('view')->render('admin/common/header', $data);
    }
}

?>
