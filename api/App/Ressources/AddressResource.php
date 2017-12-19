<?php

namespace App\Ressources;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\City;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class AddressResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE CURRENT USER ADDRESS
    // -------------------------------------------------------------------------
    public function updateCurrentUserAddress(Request $request, Response $response, $args) {
        $user = $this->getEntityManager()->find(User::class, $_SESSION['user']->getUser_id());
        if ($user instanceof User) {
            $line1 = $request->getParam('line1');
            $line2 = $request->getParam('line2');
            $city = $this->getEntityManager()->find(City::class, intval($request->getParam('city_id')));
            if ($line1 && $city instanceof City) {
                $address = $user->getAddress();
                if ($address === null) {
                    $address = new Address();
                    $this->getEntityManager()->persist($address);
                }
                $address->setLine1($line1);
                $address->setLine2($line2);
                $address->setCity($city);
                $user->setAddress($address);
                $this->getEntityManager()->flush($address);
                $this->getEntityManager()->flush($user);
            } else {
                return $response->withStatus(400, "Invalid Address");
            }
        } else {
            return $response->withStatus(401, "ERROR NOT LOGGED");
        }

        return $response;
    }
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE CURRENT USER ADDRESS
    // -------------------------------------------------------------------------
    public function updateUserAddress(Request $request, Response $response, $args) {
        $user = $this->getEntityManager()->find(User::class, intval($args['user_id']));
        if ($user instanceof User) {
            $line1 = $request->getParam('line1');
            $line2 = $request->getParam('line2');
            $city = $this->getEntityManager()->find(City::class, intval($request->getParam('city_id')));
            if ($line1 && $city instanceof City) {
                $address = $user->getAddress();
                if ($address === null) {
                    $address = new Address();
                    $this->getEntityManager()->persist($address);
                }
                $address->setLine1($line1);
                $address->setLine2($line2);
                $address->setCity($city);
                $user->setAddress($address);
                $this->getEntityManager()->flush();
            } else {
                return $response->withStatus(400, "Invalid Address");
            }
        } else {
            return $response->withStatus(401, "ERROR NOT LOGGED");
        }

        return $response;
    }
    
}
