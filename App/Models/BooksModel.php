<?php

namespace App\Models;

use Core\Model;

class BooksModel extends Model
{
    protected $table = 'books';

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(10);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);
        $totalBooks = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();
        if ($totalBooks) {
            $this->get('pagination')->setTotalItems($totalBooks->total);
        }

        return $this->get('db')->select('books.*', 'c1.name AS cat_name', 'aut1.name AS author_name', 'u1.first_name', 'u1.last_name')->from($this->table)->join('LEFT JOIN categories c1 on (books.category_id = c1.id)')->join('LEFT JOIN authors aut1 on (books.author_id = aut1.id)')->join('LEFT JOIN users u1 on (books.user_id = u1.id)')->orderBy('books.id', 'DESC')->limit($limit, $offset)->fetchAll();
    }

    public function getID($id, $admin = false)
    {
        if (! $admin) {
            $this->get('db')->where('status = ? AND', 'enabled');
        }

        return $this->get('db')->where('id = ?', $id)->fetch($this->table);
    }

    public function create($addByUrl = false, $status = 'disabled')
    {
        if ($addByUrl) {
            $this->get('db')->data('link', $this->get('request')->post('link'));
        } else {
            $pdf = $this->UploadFile();
            if ($pdf) {
                $this->get('db')->data('link', $pdf);
            }
        }

        $image = $this->UploadImage();

        if ($image) {
            $this->get('db')->data('image', $image);
        }
        if ($this->get('request')->post('status')) {
            $status = $this->get('request')->post('status');
        }
        $loginModelUserId = $this->get('load')->model('Login')->user()->id;
        $this->get('db')->data('category_id', $this->get('request')->post('category'))->data('author_id', $this->get('request')->post('author'))->data('user_id', $loginModelUserId)->data('title', $this->get('request')->post('title'))->data('description ', $this->get('request')->post('desc'))->data('views', 0)->data('downloads', 0)->data('page_count', 0)->data('created', time())->data('status', $status)->insert($this->table);
    }

    private function UploadFile()
    {
        $pdf = $this->get('request')->file('link');
        if (! $pdf->exists()) {
            return '';
        }

        return $pdf->moveTo(mto('public/files'));
    }

    private function UploadImage()
    {
        $image = $this->get('request')->file('image');
        if (! $image->exists()) {
            return '';
        }

        return $image->moveTo(mto('public/images'));
    }

    public function update($id, $addByUrl = false)
    {
        if ($addByUrl) {
            $this->get('db')->data('link', $this->get('request')->post('link'));
        } else {
            $pdf = $this->UploadFile();
            if ($pdf) {
                $this->get('db')->data('link', $pdf);
            }
        }

        $image = $this->UploadImage();

        if ($image) {
            $this->get('db')->data('image', $image);
        }

        $this->get('db')->data('category_id', $this->get('request')->post('category'))->data('author_id', $this->get('request')->post('author'))->data('title', $this->get('request')->post('title'))->data('description ', $this->get('request')->post('desc'))->data('status', $this->get('request')->post('status'))->where('id = ?', $id)->update($this->table);
    }

    public function allWithSubCategories()
    {

        $categories = $this->get('db')->orderBy('id', 'ASC')->fetchAll($this->table);

        if (! $categories) {
            return [];
        }

        return $this->buildTree($categories);
    }

    public function getBY($items = 1, $orderBy, $time = 'MONTH')
    {
        return $this->get('db')->select('books.*')->from($this->table)->join('INNER JOIN categories ON (categories.id = books.category_id AND categories.status = \'enabled\')')->where('FROM_UNIXTIME( books.created , \'%Y-%m-%d\' ) > DATE_SUB( NOW( ) , INTERVAL 1 MONTH )')->where('AND books.status = ?', 'enabled')->orderBy($orderBy, 'DESC')->limit($items)->fetchAll();
    }

    public function getBookWithComments($id)
    {
        $book = $this->get('db')->select('books.*', 'categories.name AS category', 'authors.name AS author')->from($this->table)->join('INNER JOIN categories c1 ON (c1.id = books.category_id AND c1.status = \'enabled\')')->join('LEFT JOIN categories ON books.category_id = categories.id')->join('LEFT JOIN authors ON books.author_id = authors.id')->where('books.id = ? AND books.status = ?', $id, 'enabled')->fetch();
        if (! $book) {
            return null;
        }
        $book->comments = $this->get('db')->select('comments.*', 'users.image AS user_image', 'users.first_name', 'users.last_name')->from('comments')->join('LEFT JOIN users ON comments.user_id = users.id')->where('comments.book_id = ?', $id)->fetchAll();

        return $book;
    }

    public function UpdatePageCount($page_count, $id)
    {
        $page_count = $page_count + 1;
        $this->get('db')->data('page_count', $page_count)->where('id = ?', $id)->update($this->table);
    }

    public function UpdateViews($viewsCount, $id)
    {
        $viewsCount = $viewsCount + 1;
        $this->get('db')->data('views', $viewsCount)->where('id = ?', $id)->update($this->table);
    }

    public function UpdateDownloads($downloads, $id)
    {
        $downloads = $downloads + 1;
        $this->get('db')->data('downloads', $downloads)->where('id = ?', $id)->update($this->table);
    }

    public function AuthorBooks($book_id, $author_id, $items)
    {
        return $this->get('db')->where('id != ? AND author_id = ? AND status = ?', $book_id, $author_id, 'enabled')->limit($items)->fetchAll($this->table);
    }

    public function categoryBooks($book_id, $category_id, $items)
    {
        return $this->get('db')->where('id != ? AND category_id = ? AND status = ?', $book_id, $category_id, 'enabled')->limit($items)->fetchAll($this->table);
    }

    public function addNewComment($book_id, $logged_user_id)
    {

        $this->get('db')->data('book_id', $book_id)->data('comment', $this->get('request')->post('comment'))->data('user_id', $logged_user_id)->data('created', $now = time())->insert('comments');
    }

    public function search($searchQ)
    {
        $this->get('pagination')->setItemsPerPage(12);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $searchQ = '%'.$searchQ.'%';

        $totalResults = $this->get('db')->select('COUNT(id) as total')->from($this->table)->where('title LIKE  ? ', $searchQ)->fetch();

        if ($totalResults) {
            $this->get('pagination')->setTotalItems($totalResults->total);
        }

        return $this->get('db')->where('`title` LIKE  ? ', $searchQ)->limit($limit, $offset)->fetchAll($this->table);
    }
}