<?php

namespace App\Ressources;

use App\Entity\File;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class FileResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- POST FILE
    // -------------------------------------------------------------------------
    public function postFile(Request $request, Response $response, $args) {
        $directory = $this->container['upload_directory'] . "/file/";
        $uploadedFiles = $request->getUploadedFiles();
        $uploaded_file = isset($uploadedFiles["file"]) ? $uploadedFiles["file"] : false;
        $name = $request->getParam("name");
        $description = $request->getParam("description");
        if ($uploaded_file instanceof UploadedFile && $name && $name && $description) {
            $extension = pathinfo($uploaded_file->getClientFilename(), PATHINFO_EXTENSION);
            $basename = preg_replace('` {1,}`', '_', $name) . "_" . bin2hex(random_bytes(8));
            $file = new File();
            $file->setName($name);
            $file->setDescription($description);
            $file->setUrl( $directory . $basename . "." . $extension);
            $this->getEntityManager()->persist($file);
            $this->getEntityManager()->flush();
            $uploaded_file->moveTo('.' . $file->getUrl());
            return $response->write(json_encode($file));
        } else {
            return $response->withStatus(400, "Invalid Data");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET FILE
    // -------------------------------------------------------------------------
    public function getFile(Request $request, Response $response, $args) {
        $data = $this->getEntityManager()->getRepository(File::class)->findBy(array(), array("name" => "ASC"));
        if ($data === null || $data === []) {
            return $response->withStatus(404, "No File Found");
        }
        shuffle($data);
        return $response->write(json_encode($data));
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE FILE
    // -------------------------------------------------------------------------
    public function deleteFile(Request $request, Response $response, $args) {
        $file_id = intval($args["file_id"]);
        if ($file_id > 0) {
            $data = $this->getEntityManager()->getRepository(File::class)->find($file_id);
            if ($data instanceof File) {
                unlink("." . $data->getUrl());
                $this->getEntityManager()->remove($data);
                $this->getEntityManager()->flush();
                return $response->write(true);
            } else {
                return $response->withStatus(404, "No File Found");
            }
        } else {
            return $response->withStatus(400, "Invalid Id");
        }
    }

}
