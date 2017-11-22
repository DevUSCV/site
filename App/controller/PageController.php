<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class PageController {
    
    private $container;
    
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }
    
    public function home(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/home.twig");
        return $response;
    }
    
    public function club(Request $request, Response $response, $args){
        $this->container->view->render($response, "Page/club.twig");
        return $response;
    }
    
    public function post(Request $request, Response $response, $args){
        $post_id = intval($args["post_id"]);
        $this->container->view->render($response, "Page/post.twig", Array("post_id" => $post_id));
        return $response;
    }
}
