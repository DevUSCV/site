<?php

namespace App\Entity;

class Email {

    private $headers;
    private $to;
    private $from;
    private $object;
    private $content;

    public function __construct(String $to, String $object, String $from = "noreply@uscvoile.fr") {
        $this->from = $from;
        $this->to = $to;
        $this->object = "U.S. Carmaux Voile : " . $object;

        $this->headers = 'MIME-Version: 1.0' . "\n"
                . 'Content-type: text/html; charset=ISO-8859-1' . "\n"
                . 'Reply-To: ' . $this->from . "\n" // Mail de reponse
                . 'From: "Nom_de_expediteur"<' . $this->from . '>' . "\n" // Expediteur
                . 'Delivered-to: ' . $this->to . "\n" // Destinataire
                . 'X-Mailer: PHP/' . phpversion();
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function send() {
        if ($this->content) {
            return mail($this->to, $this->object, $this->content, $this->headers);
        } else {
            return false;
        }
    }

}
