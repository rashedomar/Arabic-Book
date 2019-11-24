<?php
namespace App\Controllers\Site\Common;
use Core\Controller;
use Core\IView;

class LayoutController extends Controller
{
    public function render(IView $view)
    {
        $data['content'] = $view;

        $sections = ['header', 'footer'];

        foreach ($sections as $section) {
            $data[$section] = $this->get('load')->controller('Site/Common/'.ucfirst($section))->index();
        }

        return $this->get('view')->render('site/common/layout', $data);
    }
}

?>
