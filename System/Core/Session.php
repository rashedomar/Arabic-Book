<?php

namespace Core;

class Session
{
    public function start()
    {
        ini_set('session.use_only_cookies', 1);
        if (! session_id()) {
            session_start();
        }
    }

    /**
     * Get the value by the given $key
     *
     * @param      $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
        }
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function destroy()
    {
        session_destroy();
        unset($_SESSION);
    }

    public function pull($key)
    {
        $value = $_SESSION[$key];
        $this->remove($key);

        return $value;
    }

    public function remove($key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function all()
    {
        return $_SESSION;
    }
}