<?php

namespace App\Ressources;

use App\Entity\Reservation;
use App\Entity\ReservationDay;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class ReservationDayResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }


    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET Reservation
    // -------------------------------------------------------------------------
    public function getReservationDay(Request $request, Response $response, $args) {
        $day = intval($args["day"]);
        $month = intval($args["month"]);
        $year = intval($args["year"]);
        if($day > 0 && $month > 0 && $year > 0){
            $date = new \DateTime($year."-".$month."-".$day);
            $data = $this->getEntityManager()->getRepository(ReservationDay::class)->findOneBy(array("date" => $date));
            if($data instanceof ReservationDay){
                return $response->write(json_encode($data));
            }else{
                $reservation_day = new ReservationDay();
                $reservation_day->setDate($date);
                $reservation_day->setStatus(1);
                $reservation_day->setReservation(new \Doctrine\Common\Collections\ArrayCollection);
                $this->getEntityManager()->persist($reservation_day);
                $this->getEntityManager()->flush($reservation_day);
                return $response->write(json_encode($reservation_day));
            }
        }else{
            return $response->withStatus(400, "Invalid Date");
        }
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET Reservation
    // -------------------------------------------------------------------------
    public function getReservationDays(Request $request, Response $response, $args) {
        $number = intval($args["number_of_days"]);
        if($number > 0 && $number <= 20){
            $date = new \DateTime("NOW");
            $result_tab = [];
            for($i=0; $i<$number; $i++){
                $result_tab[$date->format("d/m/Y")] = $this->getEntityManager()->getRepository(ReservationDay::class)->findOneBy(array("date" => $date));
                $date->modify("+1 day");
            }
            return $response->write(json_encode($result_tab));
        }else{
            return $response->withStatus(400, "Max 20 Day");
        }
    }        
}
