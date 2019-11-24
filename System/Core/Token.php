<?php

namespace Core;

class Token
{
    private static $token_name = 'token';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function generate($new = false)
    {
        // Get the current token
        $token = $this->session->get(Token::$token_name);
        if ($new === true or ! $token) {
            // Generate a new unique token
            $token = substr(base64_encode(sha1(mt_rand())), 0, 27);
            // Store the new token
            $this->session->set(Token::$token_name, $token);
        }

        // Return token
        return $token;
    }

    public function check($token)
    {
        return $this->session->get(Token::$token_name) === $token;
    }
}