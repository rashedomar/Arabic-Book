<?php

namespace Core\Mailer;

use Core\DI\Container;

class Mail extends PHPMailer
{
    private $container;

    private $settings;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->settings = (object) $this->container->get('settings');

        if ($this->settings->smtp_status === 'enabled') {
            $this->isSMTP();
            $this->Host = $this->settings->smtp_host;
            $this->Port = $this->settings->smtp_port;
            $this->SMTPSecure = $this->settings->smtp_secure;
            $this->SMTPAuth = true;
            $this->Username = $this->settings->smtp_username;
            $this->Password = $this->settings->smtp_password;
        }
    }

    public function sendMail($to, $subject, $body)
    {
        $this->setFrom($this->settings->email, $this->settings->name);
        $this->addAddress($to);
        $this->Subject = $subject.' | '.$this->settings->name;
        $this->Body = $body;
        $this->isHTML(true);
        $this->CharSet = 'UTF-8';

        //$this->SMTPDebug  = 3;
        return $this->send();
    }
}