<?php
namespace App\Controllers\Admin\Common;
use Core\Controller;
use Core\IView;

class LayoutController extends Controller
{
    public function render(IView $view)
    {
        $data['content'] = $view;
        $data['header'] = $this->get('load')->controller('Admin/Common/Header', 'Admin')->index();
        $data['sidebar'] = $this->get('load')->controller('Admin/Common/Sidebar', 'Admin')->index();
        $data['footer'] = $this->get('load')->controller('Admin/Common/Footer', 'Admin')->index();

        return $this->get('view')->render('admin/common/layout', $data);
    }
}

?>
