<?php
namespace App\Controllers\Admin\Common;
use Core\Controller;

class FooterController extends Controller
{
    public function index()
    {
        $data['user'] = $this->get('LoggedUser');
        $data['token'] = $this->get('token')->generate();

        return $this->get('view')->render('admin/common/footer', $data);
    }
}

?>
