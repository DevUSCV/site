<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class PageController {
    
    private $container;
    
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }
    
//   --------------------------------------------------------------------------- PAGE D ACCUEIL
    public function home(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/home.twig");
        return $response;
    }
//   --------------------------------------------------------------------------- LE CLUB 
    public function club(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club.twig");
        return $response;
    }
    
    public function club_event(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club_event.twig");
        return $response;
    }
    
    public function club_practice(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club_practice.twig");
        return $response;
    }
    
    public function club_training(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club_training.twig");
        return $response;
    }
    
    public function club_team(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club_team.twig");
        return $response;
    }
    
    public function club_about(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club_about.twig");
        return $response;
    }
    
    public function club_post(Request $request, Response $response, $args){
        $post_id = intval($args["post_id"]);
        $this->container->view->render($response, "Page/club_post.twig", Array("post_id" => $post_id));
        return $response;
    }
   
//   --------------------------------------------------------------------------- ACTIVITE
    public function activite(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/activite.twig");
        return $response;
    }
    
//   --------------------------------------------------------------------------- RESERVATION
    public function reservation(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/reservation.twig");
        return $response;
    }
    
//   --------------------------------------------------------------------------- LOCATION
    public function location(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/location.twig");
        return $response;
    }
}
