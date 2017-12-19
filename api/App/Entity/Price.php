<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="price")
 */
class Price implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="price_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $price_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $category;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $support;

    /**
     * @var string
     * @Column(type="string", length=65535)
     */
    protected $duration;

    /**
     * @Column(type="decimal", precision=4, scale=2)
     */
    protected $price;

   

    public function jsonSerialize() {
        return array(
            'price_id' => $this->price_id,
            'category' => $this->category,
            'name' => $this->name,
            'support' => $this->support,
            'duration' => $this->duration,
            'price' => $this->price
        );
    }

}
