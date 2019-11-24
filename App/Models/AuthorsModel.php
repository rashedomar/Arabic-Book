<?php

namespace App\Models;

use Core\Model;

class AuthorsModel extends Model
{
    protected $table = 'authors';

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(7);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalAuthors = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();

        if ($totalAuthors) {
            $this->get('pagination')->setTotalItems($totalAuthors->total);
        }

        return $this->get('db')->orderBy('id', 'DESC')->limit($limit, $offset)->fetchAll($this->table);
    }

    public function create()
    {
        $image = $this->UploadImage();

        if ($image) {
            $this->get('db')->data('image', $image);
        } else {
            $this->get('db')->data('image', '');
        }

        $this->get('db')->data('name', $this->get('request')->post('name'))->data('description', $this->get('request')->post('desc'))->insert($this->table);
    }

    private function UploadImage()
    {
        $image = $this->get('request')->file('image');
        if (! $image->exists()) {
            return '';
        }

        return $image->moveTo(mto('public/images'));
    }

    public function update($id)
    {
        $image = $this->UploadImage();

        if ($image) {
            $this->get('db')->data('image', $image);
        }
        $this->get('db')->data('name', $this->get('request')->post('name'))->data('description', $this->get('request')->post('desc'))->where('id = ?', $id)->update($this->table);
    }

    public function getAuthorWithBooks($id)
    {
        $author = $this->get('db')->where('id = ?', $id)->fetch($this->table);
        if (! $author) {
            return [];
        }

        $this->get('pagination')->setItemsPerPage(12);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalBooks = $this->get('db')->select('COUNT(id) AS `total`')->from('books')->where('author_id = ? AND status = ?', $id, 'enabled')->orderBy('id', 'DESC')->fetch();

        if ($totalBooks) {
            $this->get('pagination')->setTotalItems($totalBooks->total);
        }

        $author->books = $this->get('db')->from('books')->where('books.author_id = ? AND books.status = ?', $id, 'enabled')->orderBy('books.id', 'DESC')->limit($limit, $offset)->fetchAll();

        return $author;
    }

    public function delete($id)
    {
        $tables = ['books'];
        foreach ($tables as $table) {
            $this->get('db')->where('author_id = ?', $id)->delete($table);
        }

        return $this->get('db')->where('id = ?', $id)->delete($this->table);
    }
}