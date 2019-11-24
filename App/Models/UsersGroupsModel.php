<?php

namespace App\Models;

use Core\Model;

class UsersGroupsModel extends Model
{
    protected $table = 'users_groups';

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(7);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalUsersGroups = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();

        if ($totalUsersGroups) {
            $this->get('pagination')->setTotalItems($totalUsersGroups->total);
        }

        return $this->get('db')->limit($limit, $offset)->fetchAll($this->table);
    }

    public function create()
    {

        $lastUserGroupId = $this->get('db')->data('name', $this->get('request')->post('name'))->insert($this->table)->getLastId();

        $pages = array_filter($this->get('request')->post('pages'));

        foreach ($pages as $page) {
            $this->get('db')->data('users_groups_id', $lastUserGroupId)->data('page', $page)->insert('users_groups_privileges');
        }
    }

    public function update($id)
    {

        $this->get('db')->data('name', $this->get('request')->post('name'))//  ->data('status', $this->requset->post('status'))
        ->where('id = ?', $id)->update($this->table);

        $this->get('db')->where('users_groups_id = ?', $id)->delete('users_groups_privileges');
        $pages = array_filter($this->get('request')->post('pages'));

        foreach ($pages as $page) {
            $this->get('db')->data('users_groups_id', $id)->data('page', $page)->insert('users_groups_privileges');
        }
    }

    public function getID($id)
    {
        $userGroup = parent::getID($id);

        if ($userGroup) {
            $pages = $this->get('db')->select('page')->where('users_groups_id = ?', $userGroup->id)->fetchAll('users_groups_privileges');
            $userGroup->pages = [];
            if ($pages) {

                foreach ($pages as $page) {
                    $userGroup->pages[] = $page->page;
                }
            }
        }

        return $userGroup;
    }
}