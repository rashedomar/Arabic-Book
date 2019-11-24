<?php
namespace App\Controllers\Site;
use Core\Controller;

class LogoutController extends Controller
{
    public function signOut()
    {
        $this->get('session')->destroy();

        return redirectTo('/');
    }
}

?>
