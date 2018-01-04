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
    public function home(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/home.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- PROFIL
    public function profil(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "server" => $_SERVER
        );
        $this->container->view->render($response, "Page/profil.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- TELECHARGEMENTS
    public function download(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/download.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- LE CLUB 
    public function club(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/club.twig", $param);
        return $response;
    }

    public function club_event(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/club_event.twig", $param);
        return $response;
    }

    public function club_practice(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/club_practice.twig", $param);
        return $response;
    }

    public function club_training(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/club_training.twig", $param);
        return $response;
    }

    public function club_team(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/club_team.twig", $param);
        return $response;
    }

    public function club_about(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/club_about.twig", $param);
        return $response;
    }

    public function club_post(Request $request, Response $response, $args) {
        $post_id = intval($args["post_id"]);
        $param = array(
            "user" => $this->container["user"],
            "post_id" => $post_id
        );
        $this->container->view->render($response, "Page/club_post.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- ACTIVITE
    public function activite(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/activite.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- RESERVATION
    public function reservation(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/reservation.twig", $param);
        return $response;
    }

    public function formReservation(Request $request, Response $response, $args) {
        $year = intval($request->getParam("year"));
        $month = intval($request->getParam("month")) + 1;
        $day = intval($request->getParam("day"));
        if ($year == date("Y") && $month > 0 && $month <= 12 && $day > 0 && $day <= 31) {
            $date = new \DateTime($year . "/" . $month . "/" . $day);
            $param = array(
                "user" => $this->container["user"],
                "date" => $date->format("Y/m/d")
            );

            $this->container->view->render($response, "Form/formReservation.twig", $param);
            return $response;
        } else {
            return $response->withStatus(400, "Invalid Date");
        }
    }

    public function reservationEditor(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "reservation_id" => intval($args["reservation_id"])
        );
        $this->container->view->render($response, "Form/ReservationEditor.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- LOCATION
    public function location(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/location.twig", $param);
        return $response;
    }

    public function locationEditor(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "location_price_id" => (isset($args["location_price_id"]) ? intval($args["location_price_id"]) : null)
        );
        $this->container->view->render($response, "Form/formLocation.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- GALLERIE
    public function gallery(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/gallery.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- FORMULAIRES CONNECTION
//   ---------------------------------------------------------------------------
    public function formConnection(Request $request, Response $response, $args) {
        if ($this->container["user"]) {
            return $response->write("Already Connected");
        }
        $param = array(
            "user" => $this->container["user"],
        );
        $this->container->view->render($response, "Form/formConnection.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- FORMULAIRES AJOUT FICHIER
//   ---------------------------------------------------------------------------
    public function formAddFile(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
        );
        $this->container->view->render($response, "Form/formAddFile.twig", $param);
        return $response;
    }
//   --------------------------------------------------------------------------- FORMULAIRES AJOUT SPONSOR
//   ---------------------------------------------------------------------------
    public function formAddSponsor(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
        );
        $this->container->view->render($response, "Form/formAddSponsor.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- FORMULAIRES AJOUT IMAGE
//   ---------------------------------------------------------------------------
    public function formAddImage(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
        );
        $this->container->view->render($response, "Form/formAddImage.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- ARTICLE EDITOR
//   ---------------------------------------------------------------------------
    public function articleEditor(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "article_name" => $args["article_name"]
        );

        $this->container->view->render($response, "Form/ArticleEditor.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- BLOG EDITOR
//   ---------------------------------------------------------------------------
    public function blogEditor(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "blog_post_id" => intval($args["blog_post_id"])            
        );

        $this->container->view->render($response, "Form/BlogEditor.twig", $param);
        return $response;
    }
    
//   --------------------------------------------------------------------------- USER PROFIL
//   ---------------------------------------------------------------------------
    public function userProfil(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "user_id" => intval($args["user_id"])
        );

        $this->container->view->render($response, "Page/userProfile.twig", $param);
        return $response;
    }
//   --------------------------------------------------------------------------- USER CHANGE PASSWORD
//   ---------------------------------------------------------------------------
    public function userChangePassword(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
        );

        $this->container->view->render($response, "Form/formUserChangePassword.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- VALID USER
//   ---------------------------------------------------------------------------
    public function validUser(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "token" => $args["token"]
        );
        $this->container->view->render($response, "Page/valid_user.twig", $param);
        return $response;
    }
//   --------------------------------------------------------------------------- RECOVER USER
//   ---------------------------------------------------------------------------
    public function recoverUser(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "token" => $args["token"]
        );
        $this->container->view->render($response, "Page/recover_user.twig", $param);
        return $response;
    }

//   --------------------------------------------------------------------------- VALID RESERVATION
//   ---------------------------------------------------------------------------
    public function validReservation(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "token" => $args["token"]
        );
        $this->container->view->render($response, "Page/valid_reservation.twig", $param);
        return $response;
    }

}
