<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="article_comment")
 */
class ArticleComment implements JsonSerializable{

    /**
     * @var integer
     *
     * @Id
     * @Column(name="article_comment_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $article_comment_id;

    /**
     * Many Comments have One Article.
     * @ManyToOne(targetEntity="Article", inversedBy="comment")
     * @JoinColumn(name="article_id", referencedColumnName="article_id")
     */
    protected $article;
    
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

    function getArticle() {
        return $this->article;
    }

    function getContent() {
        return $this->content;
    }

    function getAuthor_name() {
        return $this->author_name;
    }

    function getCreate_date() {
        return $this->create_date;
    }

    function setArticle_comment_id($article_comment_id) {
        $this->article_comment_id = $article_comment_id;
    }

    function setArticle($article) {
        $this->article = $article;
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
            'article_comment_id' => $this->article_comment_id,
            //'article_id' => $this->article_id,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'create_date' => $this->create_date,
        );
    }

}
