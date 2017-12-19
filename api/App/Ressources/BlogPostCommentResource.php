<?php

namespace App\Ressources;

use App\Entity\Blog;
use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class BlogPostCommentResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET BLOG POST COMMENT BY ID
    // -------------------------------------------------------------------------
    public function getBlogPostCommentByPostId(Request $request, Response $response, $args) {
        $blog_post_id = intval($args["blog_post_id"]);
        if ($blog_post_id === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->getRepository(BlogPostComment::class)->findBy(Array("blog_post" => $blog_post_id));
        }
        if ($data === null) {
            $response->write(json_encode(false));
            return $response->withStatus(404, "Comment Not Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE BLOG POST COMMENT
    // -------------------------------------------------------------------------
    public function createBlogPostComment(Request $request, Response $response, $args) {
        $blog_post_id = intval($args["blog_post_id"]);
        $content = $request->getParam("content");
        if($blog_post_id && $content && isset($_SESSION["user"]) && $_SESSION["user"] !== null){
            $comment = new BlogPostComment();
            $blog_post = $this->getEntityManager()->getRepository(BlogPost::class)->find($blog_post_id);
            if($blog_post instanceof BlogPost){
                $comment->setBlog_post($blog_post);
            }else{
                $response->write(json_encode(false));
                return $response->withStatus(400, "Blog Post Not Found");
            }
            $comment->setContent($content);
            $comment->setAuthor_name($_SESSION['user']->getLastName() . " " . $_SESSION['user']->getFirstName());
            $comment->setCreate_date(new \DateTime('now'));
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush($comment);
            $response->write(json_encode($comment));
        }else{
            $response->write(json_encode(false));
            return $response->withStatus(400, "Invalid Comment");
        }
        return $response;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE BLOG POST COMMENT
    // -------------------------------------------------------------------------
    public function deleteBlogPostComment(Request $request, Response $response, $args) {
        $blog_post_comment_id = intval($args["blog_post_comment_id"]);
        if($blog_post_comment_id > 0){
            $comment = $this->getEntityManager()->find(BlogPostComment::class, $blog_post_comment_id);
            if($comment){
                $this->getEntityManager()->remove($comment);
                $this->getEntityManager()->flush();
                return $response->write(json_encode(true));
            }else{
                $response->write(json_encode(false));
                return $response->withStatus(404, "Comment Not Found");
            }
        }else{
            $response->write(json_encode(false));
            return $response->withStatus(400, "Invalid Comment Id");
        }
    }
}
