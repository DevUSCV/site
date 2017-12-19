<?php

namespace App\Ressources;

use App\Entity\Photo;
use App\Service\ImageService;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class PhotoResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- POST PHOTO
    // -------------------------------------------------------------------------
    public function postPhoto(Request $request, Response $response, $args) {
        $directory = $this->container['upload_directory'] . "/photos/";
        $uploadedFiles = $request->getUploadedFiles();

        $file = isset($uploadedFiles["photo"]) ? $uploadedFiles["photo"] : false;
        $title = $request->getParam("title");
        $description = $request->getParam("description");
        if ($file instanceof UploadedFile && $title && $description) {
            $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8));
            $photo = new Photo();
            $photo->setTitle($title);
            $photo->setDescription($description);
            $photo->setUrl_small(sprintf('%s.%0.8s', $directory . $basename, $extension));
            $photo->setUrl_large(sprintf('%s.%0.8s', $directory . $basename . "_large", $extension));
            $is = new ImageService($file->file);
            if (empty($is->getTabErreur())) {
                $is->copier(320, 240, "." . $photo->getUrl_small());
                $is->copier(1024, 768, "." . $photo->getUrl_large());
                if (empty($is->getTabErreur())) {
                    $this->getEntityManager()->persist($photo);
                    $this->getEntityManager()->flush();
                    return $response->write(json_encode($photo));
                } else {
                    unlink($photo->getUrl_small());
                    unlink($photo->getUrl_large());
                    return $response->withStatus(400, $is->getTabErreur()[0]);
                }
            } else {
                return $response->withStatus(400, $is->getTabErreur()[0]);
            }
        } else {
            return $response->withStatus(400, "Invalid Data");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET PHOTO
    // -------------------------------------------------------------------------
    public function getPhotos(Request $request, Response $response, $args) {
        $data = $this->getEntityManager()->getRepository(Photo::class)->findAll();
        if ($data === null || $data === []) {
            return $response->withStatus(404, "No Image Found");
        }
        shuffle($data);
        return $response->write(json_encode($data));
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- PUT PHOTO
    // -------------------------------------------------------------------------
    public function updatePhoto(Request $request, Response $response, $args) {
        $photo_id = intval($request->getParam("photo_id"));
        $title = $request->getParam("title");
        $description = $request->getParam("description");
        var_dump($photo_id, $title, $description);
        if ($photo_id > 0 && $title && $description) {
            $data = $this->getEntityManager()->getRepository(Photo::class)->find($photo_id);
            if ($data instanceof Photo) {
                $data->setTitle($title);
                $data->setDescription($description);
                $this->getEntityManager()->flush($data);
            } else {
                return $response->withStatus(400, "No Photo Found");
            }
        } else {
            return $response->withStatus(400, "Invalid Data");
        }
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE PHOTO
    // -------------------------------------------------------------------------
    public function deletePhoto(Request $request, Response $response, $args) {
        $photo_id = intval($args["photo_id"]);
        if ($photo_id > 0) {
            $data = $this->getEntityManager()->getRepository(Photo::class)->find($photo_id);
            if ($data instanceof Photo) {
                unlink($data->getUrl_small());
                unlink($data->getUrl_large());
                $this->getEntityManager()->remove($data);
                $this->getEntityManager()->flush();
            } else {
                return $response->withStatus(404, "No Photo Found");
            }
        } else {
            return $response->withStatus(400, "Invalid Id");
        }
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- TOOLS
    // -------------------------------------------------------------------------

    private function moveUploadedFile($directory, UploadedFile $uploadedFile) {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

}
