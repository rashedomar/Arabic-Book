<?php
namespace App\Controllers\Site\Common;
use Core\Controller;

class FooterController extends Controller
{
    public function index()
    {
        return $this->get('view')->render('site/common/footer');
    }
}

?>
