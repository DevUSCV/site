<?php

namespace App\Ressources;

use App\Entity\Reservation;
use App\Entity\ReservationDay;
use App\Ressources\EmailRessource;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class ReservationResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET RESERVATION
    // -------------------------------------------------------------------------
    public function getReservationById(Request $request, Response $response, $args) {
        $reservation_id = $args["reservation_id"];
        $data = $this->getEntityManager()->getRepository(Reservation::class)->find($reservation_id);
        if ($data === null || empty($data)) {
            return $response->withStatus(404, "Reservation Not Found");
        } else {
            return $response->write(json_encode($data));
        }
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE RESERVATION
    // -------------------------------------------------------------------------
    public function createReservation(Request $request, Response $response, $args) {
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        $date = new \DateTime($request->getParam("date"));
        $full_name = $request->getParam("full_name");
        $email = $request->getParam("email");
        $phone = $request->getParam("phone");
        $activity = $request->getParam("activity");
        $support = $request->getParam("support");
        $people = intval($request->getParam("people"));
        $detail = $request->getParam("detail");

        $reservation_day = $this->getEntityManager()->getRepository(ReservationDay::class)->findOneBy(array("date" => $date));
        if ($reservation_day === null) {
            $reservation_day = new ReservationDay();
            $reservation_day->setDate($date);
            $reservation_day->setStatus(1);
            $reservation_day->setReservation(new \Doctrine\Common\Collections\ArrayCollection);
            $this->getEntityManager()->persist($reservation_day);
            $this->getEntityManager()->flush($reservation_day);
        }

        if (
                strlen($full_name) >= 5 &&
                preg_match($pattern, $email) === 1 &&
                strlen($phone) >= 10 &&
                strlen($activity) >= 1 &&
                strlen($support) >= 1 &&
                $people >= 1 && $people <= 20
        ) {
            $reservation = new Reservation();
            $reservation->setDate($reservation_day);
            $reservation->setFull_name($full_name);
            $reservation->setEmail($email);
            $reservation->setPhone($phone);
            $reservation->setActivity($activity);
            $reservation->setSupport($support);
            $reservation->setPeople($people);
            $reservation->setDetail($detail);
            $reservation->setCreate_date(new \DateTime("NOW"));
            $reservation->setToken(bin2hex(openssl_random_pseudo_bytes(128)));
            $this->getEntityManager()->persist($reservation);
            $this->getEntityManager()->flush($reservation);
            EmailRessource::newReservation($reservation);            
            return $response->write(true);
        } else {
            return $response->write(false)->withStatus(400, "Invalid Reservation");
        }
    }

}
