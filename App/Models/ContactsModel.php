<?php

namespace App\Models;

use Core\Model;

class ContactsModel extends Model
{
    protected $table = 'contacts';

    public function getID($id)
    {
        return $this->get('db')->select('contacts.*', 'u1.first_name', 'u1.last_name')->from($this->table)->join('LEFT JOIN users u1 on (contacts.replied_by != 0 AND contacts.replied_by = u1.id)')->where('contacts.id = ?', $id)->fetch($this->table);
    }

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(7);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalContacts = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();

        if ($totalContacts) {
            $this->get('pagination')->setTotalItems($totalContacts->total);
        }

        return $this->get('db')->select('contacts.*', 'u1.first_name', 'u1.last_name')->from($this->table)->join('LEFT JOIN users u1 on (contacts.user_id = u1.id)')->orderBy('id', 'DESC')->limit($limit, $offset)->fetchAll($this->table);
    }

    public function unread()
    {
        return $this->get('db')->select('COUNT(*) AS total_unread')->from($this->table)->where('status = ?', 0)->fetch();
    }

    public function create($userID = 0)
    {
        if ($this->container->has('LoggedUser')) {
            $userID = $this->get('LoggedUser')->id;
        }
        $this->get('db')->data('user_id', $userID)->data('name', $this->get('request')->post('name'))->data('email', $this->get('request')->post('email'))->data('title', $this->get('request')->post('title'))->data('message', $this->get('request')->post('message'))->data('reply', '')->data('replied_by', 0)->data('replied_at', 0)->data('created', time())->data('opened', 0)->data('status', 0)->insert($this->table);
    }

    public function update($id, $reply = false)
    {
        if ($reply) {
            $userID = $this->get('LoggedUser')->id;
            $this->get('db')->data('reply', $this->get('request')->post('reply'));
            $this->get('db')->data('replied_by', $userID);
            $this->get('db')->data('replied_at', time());
            $this->get('db')->data('status', 1);
        }
        $this->get('db')->data('opened', 1)->where('id = ?', $id)->update($this->table);
    }
}