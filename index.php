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
$app->get("/club/actualites", App\Controller\PageController::class . ":club")->setName("club_news");
$app->get("/club/evenements", App\Controller\PageController::class . ":club_event")->setName("club_events");
$app->get("/club/pratiques", App\Controller\PageController::class . ":club_practice")->setName("club_practice");
$app->get("/club/entrainements", App\Controller\PageController::class . ":club_training")->setName("club_training");
$app->get("/club/equipe", App\Controller\PageController::class . ":club_team")->setName("club_team");
$app->get("/club/apropos", App\Controller\PageController::class . ":club_about")->setName("club_about");
$app->get("/club/post/{post_id}", App\Controller\PageController::class . ":club_post")->setName("club_post");

$app->get("/activite", App\Controller\PageController::class . ":activite")->setName("activite");

$app->get("/reservation", App\Controller\PageController::class . ":reservation")->setName("reservation");

$app->get("/location", App\Controller\PageController::class . ":location")->setName("location");


// Run the Application
$app->run();


