<?php

require './vendor/autoload.php';

session_start();

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
        ]);

require './App/container.php';

// ----------------------------------------------------------------------------- HOME PAGE
$app->get("/", App\Controller\PageController::class . ":home")->setName("home");
$app->get("/connection", App\Controller\PageController::class . ":formConnection")->setName("login");

$app->get("/article/editor/{article_name}", App\Controller\PageController::class . ":articleEditor")->setName("ArticleEditor");
$app->get("/blog/editor/{blog_post_id}", App\Controller\PageController::class . ":blogEditor")->setName("BlogEditor");

// ----------------------------------------------------------------------------- PROFILE
$app->get("/profil", App\Controller\PageController::class . ":profil")->setName("profil");

// ----------------------------------------------------------------------------- LE CLUB
$app->get("/club", App\Controller\PageController::class . ":club")->setName("club");
$app->get("/club/actualites", App\Controller\PageController::class . ":club")->setName("club_news");
$app->get("/club/evenements", App\Controller\PageController::class . ":club_event")->setName("club_events");
$app->get("/club/pratiques", App\Controller\PageController::class . ":club_practice")->setName("club_practice");
$app->get("/club/entrainements", App\Controller\PageController::class . ":club_training")->setName("club_training");
$app->get("/club/equipe", App\Controller\PageController::class . ":club_team")->setName("club_team");
$app->get("/club/apropos", App\Controller\PageController::class . ":club_about")->setName("club_about");
$app->get("/club/post/{post_id}", App\Controller\PageController::class . ":club_post")->setName("club_post");

// ----------------------------------------------------------------------------- ACTIVITEES
$app->get("/activite", App\Controller\PageController::class . ":activite")->setName("activite");

// ----------------------------------------------------------------------------- RESERVATION
$app->get("/reservation", App\Controller\PageController::class . ":reservation")->setName("reservation");
$app->get("/reservation/formulaire", App\Controller\PageController::class . ":formReservation")->setName("formReservation");

// ----------------------------------------------------------------------------- LOCATION
$app->get("/location", App\Controller\PageController::class . ":location")->setName("location");

// ----------------------------------------------------------------------------- GELERIE
$app->get("/gallerie", App\Controller\PageController::class . ":gallery")->setName("gallery");


// Run the Application
$app->run();


