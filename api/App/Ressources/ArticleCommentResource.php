<?php

namespace App\Ressources;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class ArticleCommentResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET ARTICLE COMMENT BY ARTICLE ID
    // -------------------------------------------------------------------------
    public function getArticleCommentsByArticleId(Request $request, Response $response, $args) {
        $article_id = intval($args["article_id"]);
        if ($article_id === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->getRepository('App\Entity\ArticleComment')->findBy(Array("article_id" => $article_id));
        }
        if ($data === null) {
            return $response->withStatus(404, "Comment Not Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE ARTICLE COMMENT
    // -------------------------------------------------------------------------
    public function createArticleComment(Request $request, Response $response, $args) {
        $article_id = intval($args["article_id"]);
        $content = $request->getParam("content");
        if($article_id && $content && isset($_SESSION["user"]) && $_SESSION["user"] !== null){
            $comment = new ArticleComment();
            $article = $this->getEntityManager()->getRepository(Article::class)->find($article_id);
            if($article instanceof Article){
                $comment->setArticle($article);
            }else{
                return $response->withStatus(400, "Article Not Found");
            }
            $comment->setContent($content);
            $comment->setAuthor_name($_SESSION['user']->getLastName() . " " . $_SESSION['user']->getFirstName());
            $comment->setCreate_date(new \DateTime('now'));
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush($comment);
            $response->write(json_encode($comment));
        }else{
            return $response->withStatus(400, "Invalid Comment");
        }
        return $response;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE ARTICLE COMMENT
    // -------------------------------------------------------------------------
    public function deleteArticleComment(Request $request, Response $response, $args) {
        $comment_id = intval($args["article_comment_id"]);
        if($comment_id > 0){
            $comment = $this->getEntityManager()->find(ArticleComment::class, $comment_id);
            if($comment){
                $this->getEntityManager()->remove($comment);
                $this->getEntityManager()->flush();
            }else{
                return $response->withStatus(404, "Comment Not Found");
            }
        }else{
            return $response->withStatus(400, "Invalid Comment Id");
        }
    }
}
