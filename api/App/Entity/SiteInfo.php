<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="site_info")
 */
class SiteInfo implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="site_info_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $site_info_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $value;
    
    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setValue($value) {
        $this->value = $value;
    }

        
    public function jsonSerialize() {
        //var_dump($this->address_text);
        return array(
            'name' => $this->name,
            'value' => $this->address,
        );
    }

}
