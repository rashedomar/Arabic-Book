<?php
namespace App\Controllers\Admin\Common;
use Core\Controller;

class SidebarController extends Controller
{
    public function index()
    {
        return $this->get('view')->render('admin/common/sidebar');
    }
}

?>
