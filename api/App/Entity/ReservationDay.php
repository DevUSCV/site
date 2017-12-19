<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use JsonSerializable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="reservation_day")
 */
class ReservationDay implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="reservation_day_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $reservation_day_id;

    /** @Column(type="date", name="date") */
    protected $date;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $status;

    /**
     * One Reservation_day has Many Reservation.
     * @OneToMany(targetEntity="Reservation", mappedBy="date")
     */
    private $reservation;

    function getReservation_day_id() {
        return $this->reservation_day_id;
    }

    function getDate() {
        return $this->date->format("Y-m-d");
    }

    function getStatus() {
        return $this->status;
    }

    function getReservation() {
        return $this->reservation;
    }

    function setReservation_day_id($reservation_day_id) {
        $this->reservation_day_id = $reservation_day_id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setReservation($reservation) {
        $this->reservation = $reservation;
    }

    public function jsonSerialize() {
        $reservationTab = array();
        foreach ($this->reservation as $reservation) {
            $reservationTab[$reservation->getTime()] = true;
        }
        return array(
            'reservationçday_id' => $this->reservation_day_id,
            'date' => $this->date->format("Y-m-d"),
            'status' => $this->status,
            "reservation" => $reservationTab
        );
    }

}
