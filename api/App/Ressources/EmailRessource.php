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
        $content_head_admin = "<h1>" . $object_admin . "</h1><h3>Un moniteur la confirmera sous peut</h3>";
        $content = "date: " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "<br>"
                . "Nom complet: " . $reservation->getFull_name() . "<br>"
                . "Téléphone: " . $reservation->getPhone() . "<br>"
                . "Activité: " . $reservation->getActivity() . "<br>"
                . "Support: " . $reservation->getSupport() . "<br>"
                . "Nombre de participants: " . $reservation->getPeople() . "<br>"
                . "Votre Message: " . $reservation->getDetail() . "<br><br>"
                . "<a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";

        
        $email = new Email($reservation->getEmail(), $object, $content_head.$content);
        $email_admin = new Email( "modo", $object_admin, $content_head_admin.$content);
        return ($email_admin->send() && $email->send());
    }
    
    public static function confirmedReservation(Reservation $reservation){
        $object = "Confirmation réservation du " . (new \DateTime($reservation->getDate()))->format("d/m/Y");
        $object_admin = $object . " | " . $reservation->getFull_name();
        $content_head = "<h1>" . $object . "</h1><h3>" . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname() . " as confirmé votre réservation</h3>";
        $content_head_admin = "<h1>" . $object . "</h1><h3>" . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname() . " as confirmé la réservation</h3>";
        $content = "date: " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "<br>"
                . "Heure: " . $reservation->getTime()->format("H:i") . "<br>"
                . "Moniteur: " . $reservation->getMonitor() . "<br><br>"
                . "Nom complet: " . $reservation->getFull_name() . "<br>"
                . "Téléphone: " . $reservation->getPhone() . "<br>"
                . "Activité: " . $reservation->getActivity() . "<br>"
                . "Support: " . $reservation->getSupport() . "<br>"
                . "Nombre de participants: " . $reservation->getPeople() . "<br>"
                . "Votre Message: " . $reservation->getDetail() . "<br><br>"
                . "<a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";

        
        $email = new Email($reservation->getEmail(), $object, $content_head.$content);
        $email_admin = new Email( "modo", $object_admin, $content_head_admin.$content);
        return ($email_admin->send() && $email->send());
    }
    
    public static function deletedReservation(Reservation $reservation){
        $object = "Annulation reservation du " . (new \DateTime($reservation->getDate()))->format("d/m/Y");
        $object_admin = $object . " | " . $reservation->getFull_name();
        $content_head = "<h1>" . $object . "</h1><h3>" . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname() . " as annulé votre réservation</h3>";
        $content_head_admin = "<h1>" . $object . "</h1><h3>" . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname() . " as annulé la réservation</h3>";
        $content = "<a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";        
        $email = new Email($reservation->getEmail(), $object, $content_head.$content);
        $email_admin = new Email( "modo", $object_admin, $content_head_admin.$content);
        return ($email_admin->send() && $email->send());
    }
    
    public static function mailReservation(Reservation $reservation, String $message){
        $object = "Message de  " . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname();
        $object_admin = $object . " a " . $reservation->getFull_name();
        $content_head = "<h1>" . $object . "</h1><h3>Concernant votre demande de réservation du " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "</h3>";
        $content_head_admin = "<h1>" . $object . "</h1><h3>Concernant la demande de réservation du " . (new \DateTime($reservation->getDate()))->format("d/m/Y") . "</h3>";
        $content = $message . "<br><br><a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";        
        $email = new Email($reservation->getEmail(), $object, $content_head.$content, $_SESSION["user"]->getEmail());
        $email_admin = new Email( "modo", $object_admin, $content_head_admin.$content);
        return ($email_admin->send() && $email->send());
    }
    
    public static function contactUser(User $user, String $object, String $message){
        $object = "Message de  " . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname() . " | " . $object;
        $object_admin = "Votre message a " . $user->getFirstname() . " " . $user->getLastname();
        $content = "<h1>" . $object . "</h1><p>" . $message . "</p>".
                "<br>De " . $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname() . 
                "<br><a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";        
        $email = new Email($user->getEmail(), $object, $content, $_SESSION["user"]->getEmail());
        $email_admin = new Email( $_SESSION["user"]->getEmail(), $object_admin, $content);
        return ($email_admin->send() && $email->send());
    }    
    
    public static function userRecoverPassword(User $user){
        $object = "Récupération de compte";
        $content = "<h1>Vous avez oublier votre mot de passe</h1>" 
                . "<a href='" . $_SERVER['HTTP_HOST'] . "/recover/" . $user->getToken() . "' >Choisissez un nouveau mot de passe</a>";
                "<br><a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";        
        $email = new Email($user->getEmail(), $object, $content);
        return ($email->send());
    }    
    
    public static function userPasswordChanged(User $user){
        $object = "Changement de mot de passe";
        $content = "<h1>VVotre mot de passe as été modifier</h1>" 
                ."<br><a href='" . $_SERVER['HTTP_HOST'] . "' >Acceder au site</a>";        
        $email = new Email($user->getEmail(), $object, $content);
        return ($email->send());
    }    
}