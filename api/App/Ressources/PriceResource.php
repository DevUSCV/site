<?php

namespace App\Ressources;

use App\Entity\Price;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class PriceResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE PRICE
    // -------------------------------------------------------------------------
    public function updatePrice(Request $request, Response $response, $args) {

    }
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET PRICE BY CATEGORY
    // -------------------------------------------------------------------------
    public function getPriceByCategory(Request $request, Response $response, $args) {
        $category = $args["category"];
        $data = $this->getEntityManager()->getRepository(Price::class)->findBy(Array("category" => $category));
        if($data === null || empty($data)){
            return $response->withStatus(404, "Price Not Found");
        }else{
            return $response->write(json_encode($data));
        }
    }
    
}
