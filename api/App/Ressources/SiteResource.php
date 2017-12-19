<?php

namespace App\Ressources;

use App\Entity\Site;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class SiteResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET Site
    // -------------------------------------------------------------------------
    public function getSite(Request $request, Response $response, $args) {
        $site_id = 1;
            $data = $this->getEntityManager()->find(Site::class, $site_id);
        if ($data === null) {
            return $response->withStatus(404, "No Site Found");
        } else {
            //var_dump(json_encode($data->jsonSerialize()));
            return $response->write(json_encode($data));
        }

        return $response;
    }
}
