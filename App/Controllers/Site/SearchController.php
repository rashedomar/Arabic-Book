<?php
namespace App\Controllers\Site;
use Core\Controller;

class SearchController extends Controller
{
    public function index()
    {
        if ($this->get('request')->get('s')) {

            $searchQ = $this->get('request')->get('s');
            $this->get('html')->setTitle('نتائج البحث عن '.$searchQ);
            $results = $this->get('load')->model('Books')->search($searchQ);

            $data['url'] = str_replace(' ', '', url('/search?s= '.$searchQ.'&page='));
            $data['pagination'] = $this->get('pagination')->paginate();
            $data['results'] = $results;

            $view = $this->get('view')->render('site/search', $data);

            return $this->get('siteLayout')->render($view);
        } else {
            $this->get('html')->setTitle('لا توجد نتائج بحث');
            $data['results'] = '';
            $view = $this->get('view')->render('site/search', $data);

            return $this->get('siteLayout')->render($view);
        }
    }
}

?>
