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
     * @Column(type="string", length=500)
     */
    protected $message;
    
    /**
     * @var string
     * @Column(type="string", length=50)
     */
    protected $type;
    
    /**
     * @var string
     * @Column(type="string", length=50)
     */
    protected $category;
    
    function getReservation_id() {
        return $this->reservation_id;
    }

    function getDate() {
        return $this->date;
    }

    function getTime() {
        return $this->time->format("H");
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

    function getType() {
        return $this->type;
    }

    function getCategory() {
        return $this->category;
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

    function setType($type) {
        $this->type = $type;
    }

    function setCategory($category) {
        $this->category = $category;
    }

        
    public function jsonSerialize() {
        return array(
            'reservation_id' => $this->reservation_id,
            'date' => $this->date->getDate(),
            'time' => $this->time->format("H"),
            'create_date' => $this->create_date,
            'status' => $this->status,
            'full_name' => $this->full_name,            
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'category' => $this->category,
        );
    }

}
