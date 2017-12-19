<?php

namespace App\Ressources;

use App\Entity\LocationPrice;
use App\Service\ImageService;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class LocationPriceResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE PRICE
    // -------------------------------------------------------------------------
    public function updateLocationPrice(Request $request, Response $response, $args) {
        
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET LOCATION PRICE
    // -------------------------------------------------------------------------
    public function getLocationPrice(Request $request, Response $response, $args) {
        $data = $this->getEntityManager()->getRepository(LocationPrice::class)->findBy(array(), array("name" => "ASC"));
        if ($data === null || empty($data)) {
            return $response->withStatus(404, "Location Price Not Found");
        } else {
            return $response->write(json_encode($data));
        }
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- POST LOCATION PRICE
    // -------------------------------------------------------------------------
    public function createLocationPrice(Request $request, Response $response, $args) {
        $directory = $this->container['upload_directory'] . "/location/";
        $uploadedFiles = $request->getUploadedFiles();

        $file = isset($uploadedFiles["photo"]) ? $uploadedFiles["photo"] : false;
        $name = $request->getParam("name");
        $description = $request->getParam("description");
        $half_hour = intval($request->getParam("half_hour"));
        $hour = intval($request->getParam("hour"));
        $two_hour = intval($request->getParam("two_hour"));
        $half_day = intval($request->getParam("half_day"));
        $day = intval($request->getParam("day"));

        if ($file instanceof UploadedFile && $name && $description) {          
            $location_price = new LocationPrice();
            $location_price->setName($name);
            $location_price->setDescription($description);
            $location_price->setHalf_hour($half_hour > 0 ? $half_hour: null);
            $location_price->setHour($hour > 0 ? $hour: null);
            $location_price->setTwo_hour($two_hour > 0 ? $two_hour: null);
            $location_price->setHalf_day($half_day > 0 ? $half_day: null);
            $location_price->setDay($day > 0 ? $day: null);
            
            $basename = bin2hex(random_bytes(8));
            $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $location_price->setImage_url(sprintf('%s.%0.8s', $directory . $basename, $extension));
            
            $is = new ImageService($file->file);
            if (empty($is->getTabErreur())) {
                $is->copier(640, 480, "." . $location_price->getImage_url());
                if (empty($is->getTabErreur())) {
                    $this->getEntityManager()->persist($location_price);
                    $this->getEntityManager()->flush();
                    return $response->write(json_encode($location_price));
                } else {
                    unlink($location_price->getImage_url());
                    return $response->withStatus(400, $is->getTabErreur()[0]);
                }
            } else {
                return $response->withStatus(400, $is->getTabErreur()[0]);
            }
        }else{
            return $response->withStatus(400, "Invalid Data");
        }
    }

}
