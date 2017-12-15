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

//   --------------------------------------------------------------------------- LOCATION
    public function location(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"]
        );
        $this->container->view->render($response, "Page/location.twig", $param);
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

//   --------------------------------------------------------------------------- FORMULAIRES
//   ---------------------------------------------------------------------------
    public function formReservation(Request $request, Response $response, $args) {
        $year = intval($request->getParam("year"));
        $month = intval($request->getParam("month"));
        $day = intval($request->getParam("day"));
        $hour = intval($request->getParam("hour"));
        if ($year == date("Y") && $month > 0 && $month <= 12 && $day > 0 && $day <= 31) {
            $date = new \DateTime($year . "-" . $month . "-" . $day);
            $date->setTime($hour, 0);

            $param = array(
                "user" => $this->container["user"],
                "date" => $date->format("/Y/m/d/H")
            );

            $this->container->view->render($response, "Form/reservation.twig", $param);
            return $response;
        } else {
            return $response->withStatus(400, "Invalid Date");
        }
    }

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

    public function formArticle(Request $request, Response $response, $args) {
        $param = array(
            "user" => $this->container["user"],
            "article_name" => $args["article_name"]
        );

        $this->container->view->render($response, "Form/ArticleEditor.twig", $param);
        return $response;
    }

}
