<?php

namespace App\Ressources;

use App\Config;
use App\Entity\Email;
use App\Entity\User;
use App\Entity\Reservation;
use Slim\Http\Request;
use Slim\Http\Response;

class EmailRessource {

    public function contact(Request $request, Response $response, $args) {
        $full_name = $request->getParam("full_name");
        $reply = $request->getParam("reply");
        $object = $request->getParam("object");
        $content = $request->getParam("content");

        if($full_name && $object && $content && preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $reply)) {
            $email = new Email("modo", "Message de " . $full_name . " | " . $object, $content, $reply);
            if ($email->send()) {
                return $response->write(true);
            } else {
                $response->write(false);
                return $response->withStatus(500, "Unable to Send Mail.");
            }
        } else {
            $response->write(false);
            return $response->withStatus(500, "Invalid Mail.");
        }
    }
    
    public static function newUser(User $user){
        $object = "Inscription ";
        $content = "<h1>" . $object . Config::SITE_NAME . "</h1>"
                . "<h3>Bienvenue " . $user->getFirstname() . " " . $user->getLastname() . "</h3>"
                . "<a href='" . $_SERVER['HTTP_HOST'] . "/valid/" . $user->getToken() . "' >Validez Votre addresse Mail</a>";
        
        $email = new Email($user->getEmail(), $object, $content);
        return $email->send();
    }
    
    public static function verifiedUser(User $user){
        $object = "Votre compte est maintenant Actif";
        $content = "<h1>" . $object . "</h1>"
                . "<a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";
        
        $email = new Email($user->getEmail(), $object, $content);
        return $email->send();
    }
    
    public static function newReservation(Reservation $reservation){
        $object = "Reservation " . (new \DateTime($reservation->getDate()))->format("d/m/Y");
        $content = "<h1>" . $object . " " .Config::SITE_NAME . "</h1>"
                . "<h3>Bonjour " . $reservation->getFull_name() . "</h3>"
                . "<a href='" . $_SERVER['HTTP_HOST'] . "/reservation/valid/" . $reservation->getToken() . "' >Validez Votre reservation</a>";
        
        $email = new Email($reservation->getEmail(), $object, $content);
        return $email->send();
    }
    
    public static function verifiedReservation(Reservation $reservation){
        $object = "Votre demande de reservation du " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "  est maintenant validée";
        $object_admin = "Demande de reservation pour le " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "  est maintenant validée";
        $content_head = "<h1>" . $object . "</h1><h3>Un moniteur la confirmera sous peut</h3>";
        $content_head_admin = "<h1>" . $object . "</h1><h3>Un moniteur la confirmera sous peut</h3>";
        $content = "date: " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "<br>"
                . "Nom complet: " . $reservation->getFull_name() . "<br>"
                . "Téléphone: " . $reservation->getPhone() . "<br>"
                . "Activité: " . $reservation->getActivity() . "<br>"
                . "Support: " . $reservation->getSupport() . "<br>"
                . "Nombre de participants: " . $reservation->getPeople() . "<br>"
                . "Votre Message: " . $reservation->getDetail() . "<br>"
                . "<a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";

        
        $email = new Email($reservation->getEmail(), $object, $content_head.$content);
        $email_admin = new Email( "modo", $object_admin, $content_head_admin.$content);
        return ($email_admin->send() && $email->send());
    }

}