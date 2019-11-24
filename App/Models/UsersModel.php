<?php

namespace App\Models;

use Core\Model;

class UsersModel extends Model
{
    protected $table = 'users';

    public function create($defaultGroup = null, $email_activation_key = null)
    {
        $image = $this->UploadImage();

        if ($image) {
            $this->get('db')->data('image', $image);
        } else {
            $this->get('db')->data('image', '');
        }
        if (is_null($defaultGroup)) {
            $defaultGroup = $this->get('request')->post('users-group-id');
        }
        if (is_null($this->get('request')->post('status'))) {
            $userStatus = 'disabled';
        } else {
            $userStatus = $this->get('request')->post('status');
        }

        $this->get('db')->data('first_name', $this->get('request')->post('first-name'))->data('last_name', $this->get('request')->post('last-name'))->data('user_group_id', $defaultGroup)->data('email', $this->get('request')->post('email'))->data('password', password_hash($this->get('request')->post('password'), PASSWORD_DEFAULT))->data('status', $userStatus)->data('created', $now = time())->data('code', generateRandom(23))->data('ip', $this->get('request')->getIP())->data('verification_code', $email_activation_key)->insert($this->table);
    }

    private function UploadImage()
    {
        $image = $this->get('request')->file('image');
        if (! $image->exists()) {
            return '';
        }

        return $image->moveTo(mto('public/images'));
    }

    public function all()
    {
        $this->get('pagination')->setItemsPerPage(7);
        $currentPage = $this->get('pagination')->page();
        $limit = $this->get('pagination')->itemsPerPage();
        $offset = $limit * ($currentPage - 1);

        $totalUsers = $this->get('db')->select('COUNT(id) AS `total`')->from($this->table)->fetch();

        if ($totalUsers) {
            $this->get('pagination')->setTotalItems($totalUsers->total);
        }

        return $this->get('db')->select('users.*', 'users_groups.name AS groupName')->from('users')->join('LEFT JOIN users_groups ON (users.user_group_id = users_groups.id)')->orderBy('id', 'DESC')->limit($limit, $offset)->fetchAll();
    }

    public function update($id, $usersGroupId = null)
    {

        $image = $this->UploadImage();

        if ($image) {
            $this->get('db')->data('image', $image);
        }
        if (is_null($usersGroupId)) {
            $usersGroupId = $this->get('request')->post('users-group-id');
        }
        $password = $this->get('request')->post('password');
        if ($password) {
            $this->get('db')->data('password', password_hash($password, PASSWORD_DEFAULT));
        }
        if ($this->get('request')->post('status')) {
            $this->get('db')->data('status', $this->get('request')->post('status'));
        }

        $this->get('db')->data('first_name', $this->get('request')->post('first-name'))->data('last_name', $this->get('request')->post('last-name'))->data('user_group_id', $usersGroupId)->data('email', $this->get('request')->post('email'))->where('id = ?', $id)->update('users');
    }

    public function verify($code)
    {
        $user = $this->get('db')->where('verification_code = ?', $code)->fetch($this->table);
        if ($user) {
            $this->get('db')->data('status', 'enabled')->data('verification_code', '')->where('verification_code = ?', $user->verification_code)->update($this->table);

            return true;
        }

        return false;
    }

    public function resetCode($key)
    {
        $this->get('db')->data('code', $key)->where('email = ?', $this->get('request')->post('email'))->update($this->table);
    }

    public function newPw()
    {
        $password = $this->get('request')->post('password');
        $this->get('db')->data('password', password_hash($password, PASSWORD_DEFAULT))->data('code', generateRandom(23))->where('code = ?', $this->get('request')->post('code'))->update($this->table);
    }

    public function delete($id)
    {
        $tables = ['books', 'comments', 'contacts'];
        foreach ($tables as $table) {
            $this->get('db')->where('user_id = ?', $id)->delete($table);
        }

        return $this->get('db')->where('id = ?', $id)->delete($this->table);
    }
}