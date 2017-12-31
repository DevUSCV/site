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
            $request = $request->withParsedBody($_POST);
        $directory = $this->container['upload_directory'] . "/location/";
        
        $uploadedFiles = $request->getUploadedFiles();
        $image = isset($uploadedFiles["image"]) ? $uploadedFiles["image"] : false;
        
        $location_price_id = intval($request->getParam("location_price_id"));
        $name = $request->getParam("name");
        $description = $request->getParam("description");
        $half_hour = intval($request->getParam("half_hour"));
        $hour = intval($request->getParam("hour"));
        $two_hour = intval($request->getParam("two_hour"));
        $half_day = intval($request->getParam("half_day"));
        $day = intval($request->getParam("day"));        
        if (
                $location_price_id > 0 &&
                strlen($name) > 0 &&
                strlen($description) > 0
        ) {
            $location_price = $this->getEntityManager()->find(LocationPrice::class, $location_price_id);
            if($location_price instanceof LocationPrice){
                $location_price->setName($name);
                $location_price->setDescription($description);
                $location_price->setHalf_hour($half_hour);
                $location_price->setHour($hour);
                $location_price->setTwo_hour($two_hour);
                $location_price->setHalf_day($half_day);
                $location_price->setDay($day);
                if ($image->file) {
                    $old_image_url = $location_price->getImage_url();
                    $basename = bin2hex(random_bytes(8));
                    $extension = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
                    $location_price->setImage_url(sprintf('%s.%0.8s', $directory . $basename, $extension));
                    $is = new ImageService($image->file);
                    if (empty($is->getTabErreur())) {
                        $is->copier(1024, 768, "." . $location_price->getImage_url());
                        if ($is->getTabErreur()) {
                            unlink("." . $location_price->getImage_url());
                            return $response->write(false)->withStatus(400, $is->getTabErreur()[0]);
                        }
                        unlink($old_image_url);
                    } else {
                        return $response->write(false)->withStatus(400, $is->getTabErreur()[0]);
                    }
                }
                $this->getEntityManager()->persist($location_price);
                $this->getEntityManager()->flush();
                return $response->write(json_encode($location_price));
            }else{
                return $response->write(false)->withStatus(404, "Location Price Not Found");
            }
            
        }else{
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET LOCATION PRICE
    // -------------------------------------------------------------------------
    public function getLocationPrice(Request $request, Response $response, $args) {
        $data = $this->getEntityManager()->getRepository(LocationPrice::class)->findBy(array(), array("name" => "ASC"));
        if ($data === null || empty($data)) {
            return $response->write(false)->withStatus(404, "Location Price Not Found");
        } else {
            return $response->write(json_encode($data));
        }
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET LOCATION PRICE BY ID
    // -------------------------------------------------------------------------
    public function getLocationPriceById(Request $request, Response $response, $args) {
        $location_price_id = intval($args["location_price_id"]);
        $data = $this->getEntityManager()->getRepository(LocationPrice::class)->find($location_price_id);
        if ($data === null || empty($data)) {
            return $response->write(false)->withStatus(404, "Location Price Not Found");
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
        $image = isset($uploadedFiles["image"]) ? $uploadedFiles["image"] : false;
        $name = $request->getParam("name");
        $description = $request->getParam("description");
        $half_hour = intval($request->getParam("half_hour"));
        $hour = intval($request->getParam("hour"));
        $two_hour = intval($request->getParam("two_hour"));
        $half_day = intval($request->getParam("half_day"));
        $day = intval($request->getParam("day"));

        if ($image instanceof UploadedFile && $name && $description) {
            $location_price = new LocationPrice();
            $location_price->setName($name);
            $location_price->setDescription($description);
            $location_price->setHalf_hour($half_hour > 0 ? $half_hour : null);
            $location_price->setHour($hour > 0 ? $hour : null);
            $location_price->setTwo_hour($two_hour > 0 ? $two_hour : null);
            $location_price->setHalf_day($half_day > 0 ? $half_day : null);
            $location_price->setDay($day > 0 ? $day : null);

            $basename = bin2hex(random_bytes(8));
            $extension = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
            $location_price->setImage_url(sprintf('%s.%0.8s', $directory . $basename, $extension));

            $is = new ImageService($image->file);
            if (empty($is->getTabErreur())) {
                $is->copier(1024, 768, "." . $location_price->getImage_url());
                if (empty($is->getTabErreur())) {
                    $this->getEntityManager()->persist($location_price);
                    $this->getEntityManager()->flush();
                    return $response->write(json_encode($location_price));
                } else {
                    unlink($location_price->getImage_url());
                    return $response->write(false)->withStatus(400, $is->getTabErreur()[0]);
                }
            } else {
                return $response->write(false)->withStatus(400, $is->getTabErreur()[0]);
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE LOCATION PRICE
    // -------------------------------------------------------------------------
    public function deleteLocationPrice(Request $request, Response $response, $args) {
        $location_price_id = intval($args["location_price_id"]);
        if ($location_price_id > 0) {
            $data = $this->getEntityManager()->getRepository(LocationPrice::class)->find($location_price_id);
            if ($data instanceof LocationPrice) {
                unlink("." . $data->getImage_url());
                $this->getEntityManager()->remove($data);
                $this->getEntityManager()->flush();
                return $response->write(true);
            } else {
                return $response->withStatus(404, "No Location Price Found");
            }
        } else {
            return $response->withStatus(400, "Invalid Id");
        }
    }
}
