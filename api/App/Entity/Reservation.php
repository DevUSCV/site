<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use JsonSerializable;

/**
 * @Entity
 * @Table(name="reservation")
 */
class Reservation implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="reservation_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $reservation_id;
    
    /**
     * Many Reservation have One ReservationDay.
     * @ManyToOne(targetEntity="ReservationDay", inversedBy="reservation")
     * @JoinColumn(name="reservation_day_id", referencedColumnName="reservation_day_id")
     */
    protected $date;
        
    /** @Column(type="time", name="time") */
    protected $time; 
    
    /** @Column(type="datetime", name="create_date") */
    protected $create_date;    
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $status;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $full_name;
    
    /**
     * @var string
     * @Column(type="string", length=500)
     */
    
    protected $email;
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $phone;
        
    /**
     * @var string
     * @Column(type="string", length=50)
     */
    protected $activity;
    
    /**
     * @var string
     * @Column(type="string", length=50)
     */
    protected $support;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $monitor;
    
    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $detail;
    
        /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $message;
    
    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $token;
    
    /**
     * @Column(type="integer")
     */
    protected $people;
    
    function getReservation_id() {
        return $this->reservation_id;
    }

    function getDate() {
        return $this->date->getDate();
    }

    function getTime() {
        return $this->time;
    }

    function getCreate_date() {
        return $this->create_date;
    }

    function getStatus() {
        return $this->status;
    }

    function getFull_name() {
        return $this->full_name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }

    function getMessage() {
        return $this->message;
    }

    function getActivity() {
        return $this->activity;
    }

    function getSupport() {
        return $this->support;
    }

    function getDetail() {
        return $this->detail;
    }

    function getToken() {
        return $this->token;
    }

    function getPeople() {
        return $this->people;
    }

    function setReservation_id($reservation_id) {
        $this->reservation_id = $reservation_id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setTime($time) {
        $this->time = $time;
    }

    function setCreate_date($create_date) {
        $this->create_date = $create_date;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setFull_name($full_name) {
        $this->full_name = $full_name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setActivity($activity) {
        $this->activity = $activity;
    }

    function setSupport($support) {
        $this->support = $support;
    }

    function setDetail($detail) {
        $this->detail = $detail;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setPeople($people) {
        $this->people = $people;
    }
    
    function getMonitor() {
        return $this->monitor;
    }

    function setMonitor($monitor) {
        $this->monitor = $monitor;
    }

    
                
    public function jsonSerialize() {
        return array(
            'reservation_id' => $this->reservation_id,
            'date' => $this->date->getDate(),
            'time' => ($this->time ? $this->time->format("H:i") : null),
            'create_date' => $this->create_date,
            'status' => $this->status,
            'full_name' => $this->full_name,            
            'email' => $this->email,
            'phone' => $this->phone,
            'activity' => $this->activity,
            'support' => $this->support,
            "people" => $this->getPeople(),
            'detail' => $this->detail,
            'message' => $this->message,
            'monitor' => $this->monitor
        );
    }

}
