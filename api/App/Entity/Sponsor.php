<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="sponsor")
 */
class Sponsor implements \JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="sponsor_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $sponsor_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $url;

    function getSponsor_id() {
        return $this->sponsor_id;
    }

    function getName() {
        return $this->name;
    }

    function getUrl() {
        return $this->url;
    }

    function setSponsor_id($sponsor_id) {
        $this->sponsor_id = $sponsor_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    
    public function jsonSerialize() {
        return array(
            'sponsor_id' => $this->sponsor_id,
            'name' => $this->name,
            'url' => $this->url,
        );
    }

}
