<?php

namespace App\Ressources;

use App\Entity\Sponsor;
use App\Entity\BlogPostComment;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class SponsorResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET SPONSOR
    // -------------------------------------------------------------------------
    public function getSponsor(Request $request, Response $response, $args) {
        $data = $this->getEntityManager()->getRepository(Sponsor::class)->findBy(array(), array("name" => "ASC"));
        return $response->write(json_encode($data));
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE SPONSOR
    // -------------------------------------------------------------------------
    public function createSponsor(Request $request, Response $response, $args) {
        $name = $request->getParam("name");
        $url = $request->getParam("url");
        if($name && $url){
            $sponsor = new Sponsor();
            $sponsor->setName($name);
            $sponsor->setUrl($url);
            $this->getEntityManager()->persist($sponsor);
            $this->getEntityManager()->flush($sponsor);
            return $response->write(json_encode($sponsor));
        }else{
            $response->write(json_encode(false));
            return $response->withStatus(400, "Invalid Sponsor");
        }
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE SPONSOR
    // -------------------------------------------------------------------------
    public function deleteSponsor(Request $request, Response $response, $args) {
        $sponsor_id = intval($args["blog_post_comment_id"]);
        if($sponsor_id > 0){
            $sponsor = $this->getEntityManager()->find(Sponsor::class, $sponsor_id);
            if($sponsor){
                $this->getEntityManager()->remove($sponsor);
                $this->getEntityManager()->flush();
                return $response->write(json_encode(true));
            }else{
                $response->write(json_encode(false));
                return $response->withStatus(404, "Sponsor Not Found");
            }
        }else{
            $response->write(json_encode(false));
            return $response->withStatus(400, "Invalid Sponsor Id");
        }
    }
}
