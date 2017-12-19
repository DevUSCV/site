<?php

namespace App\Ressources;

use App\Entity\City;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class CityResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET CITY AUTOCOMPLETE
    // -------------------------------------------------------------------------
    public function getCityAutocomplete(Request $request, Response $response, $args) {
        $search = $args["search"];
        if (!$search) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->createQuery("SELECT c FROM " . City::class . " c WHERE c.name LIKE :name OR c.zipcode LIKE :zipcode") // <= DQL, not SQL
                    ->setParameter("name", $search.'%')
                    ->setParameter("zipcode", $search.'%')
                    ->setMaxResults(10)
                    ->getResult();
        }
        if ($data === null) {
            return $response->withStatus(404, "No City Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }
}
