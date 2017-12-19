<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="site")
 */
class Site implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="site_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $site_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $address;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $phone;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $google_map_url;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $facebook_url;


    
    public function jsonSerialize() {
        //var_dump($this->address_text);
        return array(
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,            
            'google_map_url' => $this->google_map_url,
            'facebook_url' => $this->facebook_url
        );
    }

}
