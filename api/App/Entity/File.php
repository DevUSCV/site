<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="file")
 */
class File implements \JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="file_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $file_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $description;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $url;

    function getFile_id() {
        return $this->file_id;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getUrl() {
        return $this->url;
    }

    function setFile_id($file_id) {
        $this->file_id = $file_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setUrl($url) {
        $this->url = $url;
    }

        
    public function jsonSerialize() {
        return array(
            'file_id' => $this->file_id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
        );
    }

}
