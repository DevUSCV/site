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
        $ignore = array("contact_mail");
        $data = $this->getEntityManager()->getRepository(SiteInfo::class)->findAll();
        if ($data === null) {
            return $response->withStatus(404, "No Site Found");
        } else {
            $siteinfo = array();
            foreach ($data as $info) {
                if (!in_array($info->getName(), $ignore)) {
                    $siteinfo[$info->getName()] = $info->getValue();
                }
            }
            return $response->write(json_encode($siteinfo));
        }

        return $response;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE SITE INFO
    // -------------------------------------------------------------------------
    public function updateSiteInfo(Request $request, Response $response, $args) {
        $ignore = array("contact_mail");
        $site_info = $request->getParsedBody();
        if($site_info){
            foreach ($site_info as $name => $value) {
                $info = $this->getEntityManager()->getRepository(SiteInfo::class)->findOneBy(array("name" => $name));
                if($info instanceof SiteInfo){
                    $info->setValue($value);
                }else{
                    return $response->write(false)->withStatus(400, "Info '" . $name . "' Do Not Exist");
                }
            }
            $this->getEntityManager()->flush();
            return $response->write(true);
        }else{
            return $response->write(false)->withStatus(400, "Invalid Data");
        }

        
    }

}
