<?php

require './vendor/autoload.php';

use Slim\Views\Twig;
use Slim\Views\TwigExtension;


$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
        ]);

require './App/container.php';

$app->get("/", App\Controller\PageController::class . ":home")->setName("home");

$app->get("/club", App\Controller\PageController::class . ":club")->setName("club");
$app->get("/post/{post_id}", App\Controller\PageController::class . ":post")->setName("post");

// Run the Application
$app->run();

        
