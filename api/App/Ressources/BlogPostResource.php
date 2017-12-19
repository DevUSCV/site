<?php

namespace App\Ressources;

use App\Entity\Blog;
use App\Entity\BlogPost;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class BlogPostResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET BLOG POST BY ID
    // -------------------------------------------------------------------------
    public function getBlogPostById(Request $request, Response $response, $args) {
        $post_id = intval($args["blog_post_id"]);
        if ($post_id === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->find(BlogPost::class, $post_id);
        }
        if ($data === null) {
            $response->write(false);
            return $response->withStatus(404, "Post Not Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE BLOG POST
    // -------------------------------------------------------------------------
    public function createBlogPost(Request $request, Response $response, $args) {
        $blog_name = $args["blog_name"];
        $title = $request->getParam("title");
        $content = $request->getParam("content");
        $commentable = boolval($request->getParam("commentable"));
        if ($blog_name && $title && $content && isset($_SESSION["user"]) && $_SESSION["user"] !== null) {
            $blog_post = new BlogPost();
            $blog_post->setBlog($this->getEntityManager()->getRepository(Blog::class)->findOneBy(Array("name" => $blog_name)));
            $blog_post->setTitle($title);
            $blog_post->setContent($content);
            $blog_post->setAuthor_name($_SESSION['user']->getLastName() . " " . $_SESSION['user']->getFirstName());
            $blog_post->setCreate_date(new \DateTime('now'));
            $blog_post->setCommentable($commentable);
            $this->getEntityManager()->persist($blog_post);
            $this->getEntityManager()->flush($blog_post);
            $response->write(json_encode($blog_post));
        } else {
            $response->write(false);
            return $response->withStatus(400, "Invalid Blog Post");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE BLOG POST
    // -------------------------------------------------------------------------
    public function updateBlogPost(Request $request, Response $response, $args) {
        $blog_post_id = intval($request->getParam("blog_post_id"));
        $title = $request->getParam("title");
        $content = $request->getParam("content");
        $commentable = boolval($request->getParam("commentable"));
        if ($blog_post_id > 0 && $title && $content && isset($_SESSION["user"]) && $_SESSION["user"] !== null) {
            $blog_post = $this->getEntityManager()->find(BlogPost::class, $blog_post_id);
            if ($blog_post instanceof BlogPost) {
                $blog_post->setTitle($title);
                $blog_post->setContent($content);
                $blog_post->setLast_editor_name($_SESSION['user']->getLastName() . " " . $_SESSION['user']->getFirstName());
                $blog_post->setLast_edit_date(new \DateTime('now'));
                $blog_post->setCommentable($commentable);
                $this->getEntityManager()->flush($blog_post);
                $response->write(true);
            } else {
                $response->write(false);
                return $response->withStatus(404, "Blog Post Not Found");
            }
        } else {
            $response->write(false);
            return $response->withStatus(400, "Invalid Blog Post");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE ARTICLE
    // -------------------------------------------------------------------------
    public function deleteBlogPost(Request $request, Response $response, $args) {
        $blog_post_id = intval($args["blog_post_id"]);
        if ($blog_post_id > 0) {
            $blog_post = $this->getEntityManager()->find(BlogPost::class, $blog_post_id);
            if ($blog_post instanceof BlogPost) {
                $this->getEntityManager()->remove($blog_post);
                $this->getEntityManager()->flush();
                return $response->write(true);
            } else {
                $response->write(false);
                return $response->withStatus(404, "Blog Post Not Found");
            }
        } else {
            $response->write(false);
            return $response->withStatus(400, "Invalid Blog Post Id");
        }
    }

}
