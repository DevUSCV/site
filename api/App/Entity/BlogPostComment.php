<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="blog_post_comment")
 */
class BlogPostComment implements JsonSerializable{

    /**
     * @var integer
     *
     * @Id
     * @Column(name="article_comment_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $blog_post_comment_id;

    /**
     * Many Comments have One Article.
     * @ManyToOne(targetEntity="BlogPost", inversedBy="comment")
     * @JoinColumn(name="blog_post_id", referencedColumnName="blog_post_id")
     */
    protected $blog_post;
    
    /**
     * @var string
     * @Column(type="string", length=65535)
     */
    protected $content;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $author_name;

    /** @Column(type="datetime", name="create_date") */
    protected $create_date;
    
    function getArticle_comment_id() {
        return $this->article_comment_id;
    }

    function getBlog_post_comment_id() {
        return $this->blog_post_comment_id;
    }

    function getBlog_post() {
        return $this->blog_post;
    }

    function getContent() {
        return $this->content;
    }

    function getAuthor_name() {
        return $this->author_name;
    }

    function getCreate_date() {
        return $this->create_date ? $this->create_date->format("d/m/Y H:i:s") : null;
    }

    function setBlog_post_comment_id($blog_post_comment_id) {
        $this->blog_post_comment_id = $blog_post_comment_id;
    }

    function setBlog_post($blog_post) {
        $this->blog_post = $blog_post;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setAuthor_name($author_name) {
        $this->author_name = $author_name;
    }

    function setCreate_date($create_date) {
        $this->create_date = $create_date;
    }

            
    public function jsonSerialize() {
        return array(
            'blog_post_comment_id' => $this->blog_post_comment_id,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'create_date' => $this->getCreate_date(),
        );
    }

}
