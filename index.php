<?php

require './vendor/autoload.php';

session_start();

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => false
    ]
        ]);

require './App/container.php';

// ----------------------------------------------------------------------------- HOME PAGE
$app->get("/", App\Controller\PageController::class . ":home")->setName("home");
$app->get("/connection", App\Controller\PageController::class . ":formConnection")->setName("login");

$app->get("/article/editor/{article_name}", App\Controller\PageController::class . ":articleEditor")->setName("ArticleEditor");
$app->get("/blog/editor/{blog_post_id}", App\Controller\PageController::class . ":blogEditor")->setName("BlogEditor");
$app->get("/valid/{token}", App\Controller\PageController::class . ":validUser")->setName("validUser");
$app->get("/recover/{token}", App\Controller\PageController::class . ":recoverUser")->setName("recoverUser");
$app->get("/reservation/valid/{token}", App\Controller\PageController::class . ":validReservation")->setName("validReservation");

// ----------------------------------------------------------------------------- PROFILE
$app->get("/profil", App\Controller\PageController::class . ":profil")->setName("profil");
$app->get("/profil/{user_id}", App\Controller\PageController::class . ":userProfil")->setName("userProfil");
$app->get("/form/changepassword", App\Controller\PageController::class . ":userChangePassword")->setName("userChangePassword");

// ----------------------------------------------------------------------------- DOWNLOAD
$app->get("/download", App\Controller\PageController::class . ":download")->setName("download");
$app->get("/addfile", App\Controller\PageController::class . ":formAddFile")->setName("addFile");

$app->get("/addsponsor", App\Controller\PageController::class . ":formAddSponsor")->setName("formAddSponsor");

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
$app->get("/reservation/editor/{reservation_id}", App\Controller\PageController::class . ":reservationEditor")->setName("reservationEditor");

// ----------------------------------------------------------------------------- LOCATION
$app->get("/location", App\Controller\PageController::class . ":location")->setName("location");
$app->get("/location/editor", App\Controller\PageController::class . ":locationEditor")->setName("locationEditor");
$app->get("/location/editor/{location_price_id}", App\Controller\PageController::class . ":locationEditor")->setName("locationEditor");

// ----------------------------------------------------------------------------- GELERIE
$app->get("/gallerie", App\Controller\PageController::class . ":gallery")->setName("gallery");
$app->get("/addimage", App\Controller\PageController::class . ":formAddImage")->setName("addImage");


// Run the Application
$app->run();


