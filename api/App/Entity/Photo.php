<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="photo")
 */
class Photo implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="photo_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $photo_id;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $url_large;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $url_small;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $description;
    
    function getPhoto_id() {
        return $this->photo_id;
    }

    function getUrl_large() {
        return $this->url_large;
    }

    function getUrl_small() {
        return $this->url_small;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function setPhoto_id($photo_id) {
        $this->photo_id = $photo_id;
    }

    function setUrl_large($url_large) {
        $this->url_large = $url_large;
    }

    function setUrl_small($url_small) {
        $this->url_small = $url_small;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

            
    public function jsonSerialize() {
        return array(
            'photo_id' => $this->photo_id,            
            'url_small' => $this->url_small,
            'url_large' => $this->url_large,
            'title' => $this->title,            
            'description' => $this->description
        );
    }

}
