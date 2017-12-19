<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="location_price")
 */
class LocationPrice implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="location_price_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $location_price_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $description;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $image_url;
    
    /**
     * @Column(type="integer")
     */
    protected $half_hour;
    
    /**
     * @Column(type="integer")
     */
    protected $hour;
    
    /**
     * @Column(type="integer")
     */
    protected $two_hour;
    
    /**
     * @Column(type="integer")
     */
    protected $half_day;
    
    /**
     * @Column(type="integer")
     */
    protected $day;


    function getLocation_price_id() {
        return $this->location_price_id;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getImage_url() {
        return $this->image_url;
    }

    function getHalf_hour() {
        return $this->half_hour;
    }

    function getHour() {
        return $this->hour;
    }

    function getTwo_hour() {
        return $this->two_hour;
    }

    function getHalf_day() {
        return $this->half_day;
    }

    function getDay() {
        return $this->day;
    }

    function setLocation_price_id($location_price_id) {
        $this->location_price_id = $location_price_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setImage_url($image_url) {
        $this->image_url = $image_url;
    }

    function setHalf_hour($half_hour) {
        $this->half_hour = $half_hour;
    }

    function setHour($hour) {
        $this->hour = $hour;
    }

    function setTwo_hour($two_hour) {
        $this->two_hour = $two_hour;
    }

    function setHalf_day($half_day) {
        $this->half_day = $half_day;
    }

    function setDay($day) {
        $this->day = $day;
    }

    
    public function jsonSerialize() {
        return array(
            'location_price_id' => $this->location_price_id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'half_hour' => $this->half_hour,
            'hour' => $this->hour,
            'two_hour' => $this->two_hour,
            'half_day' => $this->half_day,
            'day' => $this->day
        );
    }

}
