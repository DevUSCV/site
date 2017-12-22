<?php

namespace App\Entity;

use App\Config;

class Email {

    private $headers;
    private $to;
    private $from;
    private $object;
    private $content;

    public function __construct(String $to, String $object, String $content, String $from = "noreply@" . Config::DOMAIN) {
        $this->from = $from;
        $this->to = $to;
        $this->object = Config::SITE_NAME . " : " . $object;
        $this->content = $content;
    }

    public function send() {        
        if ($this->to && $this->content && $this->object) {
            $this->headers = 'MIME-Version: 1.0' . "\n"
                . 'Content-type: text/html; charset=ISO-8859-1' . "\n"
                . 'From: "' . Config::SITE_NAME . '" <noreply@' . Config::DOMAIN . '>' . "\n" 
                . 'Reply-To: ' . $this->from . "\n"                 
                . 'Delivered-to: ' . $this->to . "\n" 
                . 'X-Mailer: PHP/' . phpversion();
            return mail($this->to, $this->object, $this->content, $this->headers);
        } else {
            return false;
        }
    }

    function getTo() {
        return $this->to;
    }

    function getFrom() {
        return $this->from;
    }

    function getObject() {
        return $this->object;
    }

    function getContent() {
        return $this->content;
    }

    function setTo($to) {
        $this->to = $to;
    }

    function setFrom($from) {
        $this->from = $from;
    }

    function setObject($object) {
        $this->object = $object;
    }

    function setContent($content) {
        $this->content = $content;
    }


    
}
