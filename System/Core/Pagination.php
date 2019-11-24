<?php

namespace Core;

class Pagination
{
    private $request;

    private $totalItems;

    private $itemsPerPage = 12;

    private $lastPage;

    private $page = 1;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setCurrentPage();
    }

    private function setCurrentPage()
    {
        // ?page=1
        // ?page=2
        $page = $this->request->get('page');

        if (! is_numeric($page) OR $page < 1) {
            $page = 1;
        }

        $this->page = $page;
    }

    public function nextPage()
    {
        return $this->page == $this->lastPage ? $this->lastPage : $this->page + 1;
    }

    public function prePage()
    {
        return $this->page == 1 ? 1 : $this->page - 1;
    }

    public function page()
    {
        return $this->page;
    }

    public function itemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function lastPage()
    {
        return $this->lastPage;
    }

    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;

        return $this;
    }

    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

    public function paginate()
    {
        $this->setLastPage();

        return $this;
    }

    private function setLastPage()
    {
        $this->lastPage = ceil($this->totalItems / $this->itemsPerPage);
    }
}

?>
