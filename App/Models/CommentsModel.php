<?php

namespace App\Models;

use Core\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(7);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalComments = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();

        if ($totalComments) {
            $this->get('pagination')->setTotalItems($totalComments->total);
        }

        return $this->get('db')->select('comments.*', 'u1.first_name,u1.last_name, b1.title AS book_title')->from('comments')->join('LEFT JOIN users u1 on (comments.user_id = u1.id)')->join('LEFT JOIN books b1 on (comments.book_id = b1.id)')->orderBy('comments.id', 'DESC')->limit($limit, $offset)->fetchAll();
    }

    public function update($id)
    {
        $this->get('db')->data('comment', $this->get('request')->post('comment'))->where('id = ?', $id)->update($this->table);
    }
}