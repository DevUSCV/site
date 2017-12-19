<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="slide")
 */
class Slide implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="slide_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $slide_id;

    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $img_url;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $content;
    
    /**
     * @var string
     * @Column(type="string", length=500)
     */
    protected $position;

    
    public function jsonSerialize() {
        //var_dump($this->address_text);
        return array(
            'slide_id' => $this->slide_id,
            'img_url' => $this->img_url,
            'title' => $this->title,            
            'content' => $this->content,
            'position' => $this->position
        );
    }

}
