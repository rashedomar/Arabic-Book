<?php

namespace Core;

use Core\DI\Container;

class Recaptcha
{
    private $container;

    private $secretKey;

    private $siteKey;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->siteKey = $this->container->get('settings', false)['recaptcha_key'];
        $this->secretKey = $this->container->get('settings', false)['recaptcha_secret'];
    }

    public function response()
    {
        return $this->send();
    }

    private function send()
    {
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($this->fields()));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        $captcha = json_decode($response);

        return $captcha->success;
    }

    private function fields()
    {
        $data = [
            'secret' => $this->secretKey,
            'response' => $this->container->get('request')->post('g-recaptcha-response'),
            'remoteip' => $this->container->get('request')->post('REMOTE_ADDR'),
        ];

        return $data;
    }

    public function widget($theme = 'light', $size = 'normal')
    {
        return '<div class="g-recaptcha" data-sitekey="'.$this->siteKey.'" data-theme="'.$theme.'" data-size="'.$size.'"></div>';
    }
}