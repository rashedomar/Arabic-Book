<?php

namespace App\Models;

use Core\Model;

class CategoriesModel extends Model
{
    protected $table = 'categories';

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(7);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalCats = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();

        if ($totalCats) {
            $this->get('pagination')->setTotalItems($totalCats->total);
        }

        return $this->get('db')->select('c1.*', 'c2.name as parent_name')->from('categories c1')->join('left join categories c2 on (c1.parent_id = c2.id)')->orderBy('id', 'DESC')->limit($limit, $offset)->fetchAll();
    }

    public function create()
    {
        $parent_id = $this->get('request')->post('pid') === 'parent' ? '0' : $this->get('request')->post('pid');
        $this->get('db')->data('name', $this->get('request')->post('name'))->data('parent_id', $parent_id)->data('status', $this->get('request')->post('status'))->insert($this->table);
    }

    public function update($id)
    {
        $parent_id = $this->get('request')->post('pid') === 'parent' ? '0' : $this->get('request')->post('pid');
        $this->get('db')->data('name', $this->get('request')->post('name'))->data('status', $this->get('request')->post('status'))->data('parent_id', $parent_id)->where('id = ?', $id)->update($this->table);
    }

    public function allWithSubCategories()
    {

        $categories = $this->get('db')->where('status = ?', 'enabled')->orderBy('id', 'ASC')->fetchAll($this->table);

        if (! $categories) {
            return [];
        }

        return $this->buildTree($categories);
    }

    public function buildTree($src_arr, $parent_id = 0, $tree = [])
    {
        foreach ($src_arr as $idx => $row) {
            if ($row->parent_id == $parent_id) {
                foreach ($row as $k => $v) {
                    $tree[$row->id][$k] = $v;
                }
                $tree[$row->id]['children'] = $this->buildTree($src_arr, $row->id);
            }
        }

        return $tree;
    }

    public function delete($id)
    {
        $tables = ['books'];
        foreach ($tables as $table) {
            $this->get('db')->where('category_id = ?', $id)->delete($table);
        }

        return $this->get('db')->where('id = ? OR parent_id = ?', $id, $id)->delete($this->table);
    }

    public function getPopularParentCatsOnly($items = 1)
    {
        return $this->get('db')->select('categories.id', 'categories.name')->select('(SELECT COUNT(books.id) FROM books WHERE books.status="enabled" AND books.category_id=categories.id) AS total_books')->from($this->table)->where('categories.status = ?', 'enabled')->orderBy('total_books', 'DESC')->having('total_books > 0')->limit($items)->fetchAll();
    }

    public function getCategoryWithBooks($id)
    {

        $category = $this->get('db')->where('id = ? AND status = ?', $id, 'enabled')->fetch($this->table);
        if (! $category) {
            return [];
        }

        $this->get('pagination')->setItemsPerPage(12);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalBooks = $this->get('db')->select('COUNT(id) AS `total`')->from('books')->where('category_id = ? AND status = ?', $id, 'enabled')->orderBy('id', 'DESC')->fetch();

        if ($totalBooks) {
            $this->get('pagination')->setTotalItems($totalBooks->total);
        }

        $category->books = $this->get('db')->select('books.*', 'authors.name AS author_name')->select('(SELECT COUNT(comments.id) FROM comments WHERE comments.book_id=books.id) AS total_comments')->from('books')->join('LEFT JOIN authors ON books.author_id = authors.id')->where('books.category_id = ? AND books.status = ?', $id, 'enabled')->orderBy('books.id', 'DESC')->limit($limit, $offset)->fetchAll();

        return $category;
    }

    public function getChildCats($id)
    {
        return $this->get('db')->from($this->table)->where('parent_id = ? AND status = ?', $id, 'enabled')->fetchAll($this->table);
    }

    public function getParentCatsWithTotalBooks()
    {
        return $this->get('db')->select('categories.id', 'categories.name')->select('(SELECT COUNT(books.id) FROM books WHERE books.status="enabled" AND books.category_id=categories.id) AS total_books')->from($this->table)->where('parent_id = ? AND status = ?', 0, 'enabled')->having('total_books > 0')->fetchAll();
    }
}