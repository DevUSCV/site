<?php

namespace App\Ressources;

use App\Entity\Reservation;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class ReservationResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }


    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET Reservation
    // -------------------------------------------------------------------------
    public function getReservationById(Request $request, Response $response, $args) {
        $reservation_id = $args["reservation_id"];
        $data = $this->getEntityManager()->getRepository(Reservation::class)->find($reservation_id);
        if($data === null || empty($data)){
            return $response->withStatus(404, "Reservation Not Found");
        }else{
            return $response->write(json_encode($data));
        }
    }        
}
