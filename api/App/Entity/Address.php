<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="address")
 */
class Address implements \JsonSerializable{

    /**
     * @var integer
     *
     * @Id
     * @Column(name="address_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $address_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $line1;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $line2;

    /**
     * @ManyToOne(targetEntity="City")
     * @JoinColumn(name="city_id", referencedColumnName="city_id")
     */
    private $city;

    function getAddress_id() {
        return $this->address_id;
    }

    function getLine1() {
        return $this->line1;
    }

    function getLine2() {
        return $this->line2;
    }

    function getCity() {
        return $this->city;
    }

    function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }

    function setLine1($line1) {
        $this->line1 = $line1;
    }

    function setLine2($line2) {
        $this->line2 = $line2;
    }

    function setCity($city) {
        $this->city = $city;
    }

        public function jsonSerialize() {
        return array(
            'address_id' => $this->address_id,
            'line1' => $this->line1,
            'lise2' => $this->line2,
            'city' => $this->city,
        );
    }
}
