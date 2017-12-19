<?php

namespace App\Entity;

use JsonSerializable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="article")
 */
class Article implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="article_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $article_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $title;

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

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $last_editor_name;

    /** @Column(type="datetime", name="create_date") */
    protected $create_date;

    /** @Column(type="datetime", name="last_edit_date") */
    protected $last_edit_date;

    /**
     * One Article has Many ArticleComments.
     * @OneToMany(targetEntity="ArticleComment", mappedBy="article")
     */
    private $comment;

    public function __construct() {
        $this->comment = new ArrayCollection();
    }

    function getArticle_id() {
        return $this->article_id;
    }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function getAuthor_name() {
        return $this->author_name;
    }

    function getLast_editor_name() {
        return $this->last_editor_name;
    }

    function getCreate_date() {
        return $this->create_date;
    }

    function getLast_edit_date() {
        return $this->last_edit_date;
    }

    function setArticle_id($article_id) {
        $this->article_id = $article_id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setAuthor_name($author_name) {
        $this->author_name = $author_name;
    }

    function setLast_editor_name($last_editor_name) {
        $this->last_editor_name = $last_editor_name;
    }

    function setCreate_date($create_date) {
        $this->create_date = $create_date;
    }

    function setLast_edit_date($last_edit_date) {
        $this->last_edit_date = $last_edit_date;
    }

    public function jsonSerialize() {
        return array(
            'article_id' => $this->article_id,
            'name' => $this->name,
            'title' => $this->title,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'last_editor_name' => $this->last_editor_name,
            'create_date' => $this->create_date,
            'last_edit_date' => $this->last_edit_date,
            'comment' => $this->comment->toArray()
        );
    }

}
