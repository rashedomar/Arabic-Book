<?php

namespace App\Models;

use Core\Model;

class LoginModel extends Model
{
    protected $table = 'users';

    private $user;

    public function isValidLogin($email, $pass)
    {

        $user = $this->get('db')->where('email = ?', $email)->fetch($this->table);

        if (! $user) {
            return false;
        }

        if (password_verify($pass, $user->password)) {
            $this->setIp($user->id);
            $this->setUser($user);

            return true;
        } else {
            return false;
        }
    }

    private function setIp($id)
    {
        $lastIp = $this->get('request')->getIP();
        $this->get('db')->data('ip', $lastIp)->where('id = ?', $id)->update($this->table);
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->container->addService('LoggedUser', $user);
    }

    public function user()
    {
        if (! $this->container->has('LoggedUser')) {
            $this->isLogged();
        }

        return $this->container->get('LoggedUser', false);
    }

    public function isLogged()
    {
        if ($this->get('session')->has('login')) {
            $code = $this->get('session')->get('login');
        } else {
            $code = '';
        }
        $user = $this->get('db')->where('code = ?', $code)->fetch($this->table);

        if (! $user) {
            return false;
        }

        $this->setUser($user);

        return true;
    }
}