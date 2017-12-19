<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="license")
 */
class License implements \JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="license_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $license_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $number;

    public function jsonSerialize() {
        return array(
            'license_id' => $this->license_id,
            'type' => $this->type,
            'number' => $this->number,
        );
    }

}
