<?php

namespace App\Ressources;

use App\Entity\Slide;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class SlideResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET SLIDES
    // -------------------------------------------------------------------------
    public function getSlide(Request $request, Response $response, $args) {
        $site_id = 1;
            $data = $this->getEntityManager()->getRepository(Slide::class)->findAll();
        if ($data === null) {
            return $response->withStatus(404, "No Slides Found");
        } else {
            //var_dump(json_encode($data->jsonSerialize()));
            return $response->write(json_encode($data));
        }

        return $response;
    }
}
