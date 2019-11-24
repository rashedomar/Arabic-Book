<?php

namespace Core;

/**
 * This class is responsible for handling all responses as the output
 * will be passed to it to display it in the browser
 */
class Response
{
    /**
     * Content
     *
     * @var string $content
     */
    private $content = '';

    private $headers = [];

    /**
     * Set the output that will be sent to the browser
     *
     * @param String $content
     * @return void
     */
    public function setOutput($content)
    {
        $this->content = $content;
    }

    /**
     * Send the headers and the output
     *
     * @return void
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendOutput();
    }

    private function sendHeaders()
    {
        foreach ($this->headers as $header => $value) {
            header($header.':'.$value);
        }
    }

    /**
     * Send Output
     *
     * @return void
     */
    private function sendOutput()
    {
        echo $this->content;
    }

    /**
     * Add new header that will be sent to the browser
     *
     * @param String $header
     * @param String $value
     * @return void
     */
    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }
}
