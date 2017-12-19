<?php

namespace App\Entity;

use JsonSerializable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="blog")
 */
class Blog implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="blog_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $blog_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * One Blog has Many BlogPost.
     * @OneToMany(targetEntity="BlogPost", mappedBy="blog")
     * @OrderBy({"create_date" = "DESC"})
     */
    private $post;

    public function __construct() {
        $this->post = new ArrayCollection();
    }

    function getBlog_id() {
        return $this->blog_id;
    }

    function getName() {
        return $this->name;
    }

    function getPost() {
        return $this->post;
    }

    function setBlog_id($blog_id) {
        $this->blog_id = $blog_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPost($post) {
        $this->post = $post;
    }

    public function jsonSerialize() {
        $posts = Array();
        foreach ($this->post as $post) {
            $posts[] = Array(
                "blog_post_id" => $post->getBlog_post_id(),
                "title" => $post->getTitle(),
                "content" => $post->getExcerpt(),
                'author_name' => $post->getAuthor_name(),
                'create_date' => $post->getCreate_date(),
                'last_editor_name' => $post->getLast_editor_name(),
                'last_edit_date' => $post->getLast_edit_date(),
                'comment_count' => count($post->getComment())
            );
        }
        return array(
            'blog_id' => $this->blog_id,
            'name' => $this->name,
            'post' => $posts,
        );
    }

}
