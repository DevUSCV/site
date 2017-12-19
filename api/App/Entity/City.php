<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="city")
 */
class City implements \JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="city_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $city_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $zipcode;

    function getCity_id() {
        return $this->city_id;
    }

    function getName() {
        return $this->name;
    }

    function getZipcode() {
        return $this->zipcode;
    }

    function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function jsonSerialize() {
        return array(
            'city_id' => $this->city_id,
            'name' => $this->name,
            'zipcode' => $this->zipcode,
        );
    }

}
