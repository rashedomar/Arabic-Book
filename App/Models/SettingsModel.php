<?php

namespace App\Models;

use Core\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';

    private $settings = [];

    public function getKey($key)
    {
        return array_key_exists($key, $this->settings) ? $this->settings[$key] : null;
    }

    public function getAllKeys()
    {
        return (object) $this->settings;
    }

    public function update()
    {
        $keys = [
            'name',
            'desc',
            'tags',
            'close_msg',
            'status',
            'email',
            'can_register',
            'default_users_group',
            'recaptcha_key',
            'recaptcha_secret',
            'smtp_status',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'smtp_secure',
            'allowed_group_addbooks',
            'default_status_addbooks',
            'animate',
        ];

        foreach ($keys as $key) {
            if (! is_null($this->get('request')->post($key))) {
                $this->get('db')->where('`key` = ?', $key)->delete($this->table);
            }
        }

        foreach ($keys as $key) {
            if (! is_null($this->get('request')->post($key))) {
                $this->get('db')->data('`key`', $key)->data('`value`', $this->get('request')->post($key))->insert($this->table);
            }
        }
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        $this->loadAll();

        return $this->settings;
    }

    public function loadAll()
    {
        foreach ($this->all() AS $setting) {
            $this->settings[$setting->key] = $setting->value;
        }
    }
}
