<?php

namespace App\Ressources;

use App\Entity\Blog;
use App\Entity\BlogPost;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class BlogResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET BLOG BY NAME
    // -------------------------------------------------------------------------
    public function getBlogByname(Request $request, Response $response, $args) {
        $name = $args["blog_name"];
        
        $data = $this->getEntityManager()->getRepository(\App\Entity\Blog::class)->findBy(Array("name" => $name));

        if ($data === null || $data === []) {
            return $response->withStatus(404, "Blog Not Found");
        } else {
            $response->write(json_encode($data[0]));
        }

        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE BLOG
    // -------------------------------------------------------------------------
    public function createBlog(Request $request, Response $response, $args) {
        $name = $request->getParam("name");
        if($name){
            $blog = new Blog();
            $blog->setName($name);
            $this->getEntityManager()->persist($blog);
            $this->getEntityManager()->flush($blog);
        }else{
            return $response->withStatus(400, "Invalid Blog");
        }
        return $response;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE BLOG
    // -------------------------------------------------------------------------
    public function updateBlog(Request $request, Response $response, $args) {
        $blog_id = intval($request->getParam("blog_id"));
        $name = $request->getParam("name");
        if($blog_id > 0 && $name){
            $blog = $this->getEntityManager()->find(Blog::class, $blog_id);
            if($blog instanceof Blog){
                $blog->setName($name);
                $this->getEntityManager()->flush($blog);
            }else{
                return $response->withStatus(404, "Blog Not Found");
            }
            
        }else{
            return $response->withStatus(400, "Invalid Blog");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE blog
    // -------------------------------------------------------------------------
    public function deleteBlog(Request $request, Response $response, $args) {
        $blog_id = intval($args["blog_id"]);
        if($blog_id > 0){
            $blog = $this->getEntityManager()->find(Blog::class, $blog_id);
            if($blog){
                $this->getEntityManager()->remove($blog);
                $this->getEntityManager()->flush();
            }else{
                return $response->withStatus(404, "Blog Not Found");
            }
        }else{
            return $response->withStatus(400, "Invalid Blog Id");
        }
    }
}
