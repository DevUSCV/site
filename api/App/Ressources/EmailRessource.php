<?php

namespace App\Ressources;

use App\Entity\Email;
use Slim\Http\Request;
use Slim\Http\Response;

class EmailRessource{
    
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }
        
    public function contact(Request $request, Response $response, $args) {
        
        $email = new Email( "vicentedelasvega@gmail.com",  "TEST ENVOIE MAIL");
        var_dump($email->setContent("COOL !!!")->send());
        return $response->write("ok");
    }
}
