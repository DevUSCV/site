<?php

namespace App\Ressources;

use App\Entity\SiteInfo;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class SiteInfoResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET SITE INFO
    // -------------------------------------------------------------------------
    public function getSiteInfo(Request $request, Response $response, $args) {
            $data = $this->getEntityManager()->getRepository(SiteInfo::class)->findAll();
        if ($data === null) {
            return $response->withStatus(404, "No Site Found");
        } else {
            $siteinfo = array();
            foreach ($data as $info){
            $siteinfo[$info->getName()] = $info->getValue();
            }
            return $response->write(json_encode($siteinfo));
        }

        return $response;
    }
}
