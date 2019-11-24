<?php
namespace App\Controllers\Site;
use Core\Controller;

class AccessController extends Controller
{
    public function index()
    {
        $ignoredPages = ['/'];
        $currentPage = $this->get('request')->getUrl();
        $siteStatus = $this->get('settings')['status'];
        if (in_array($currentPage, $ignoredPages) OR strpos($currentPage, '/active/') === 0) {
            return false;
        }
        $user = $this->get('load')->model('Login')->user();
        if ($siteStatus === 'disabled' OR ($user AND $user->status === 'disabled')) {
            return redirectTo('/');
        }
    }
}

?>
