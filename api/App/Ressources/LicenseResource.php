<?php

namespace App\Ressources;

use App\Entity\License;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use \PhpOffice\PhpSpreadsheet\IOFactory;

class LicenseResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPLOAD LICENSE
    // -------------------------------------------------------------------------
    public function uploadLicense(Request $request, Response $response, $args) {
        $uploadedFiles = $request->getUploadedFiles();

        $file = isset($uploadedFiles["license"]) ? $uploadedFiles["license"] : false;
        if ($file instanceof UploadedFile && $file->getError() === UPLOAD_ERR_OK) {
            $license_file_ext = "xlsx";
            $license_file_path = "./uploads/file/licenses." . $license_file_ext;
            $file->moveTo($license_file_path);
            try {
                $inputFileType = IOFactory::identify($license_file_path);
                $reader = IOFactory::createReader($inputFileType);
                $spreadsheet = @$reader->load($license_file_path);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                for ($i = 2; $i <= count($sheetData); $i++) {
                    $license = new License();
                    $license->setNumber($sheetData[$i]["A"]);
                    $license->setLastname(ucfirst(strtolower($sheetData[$i]["B"])));
                    $license->setFirstname(ucfirst(strtolower($sheetData[$i]["C"])));
                    $license->setSex($sheetData[$i]["D"]);
                    $license->setBirth_date($sheetData[$i]["E"]);
                    $license->setAddress(ucfirst(strtolower($sheetData[$i]["F"])));
                    $license->setZipcode($sheetData[$i]["G"]);
                    $license->setCity(ucfirst(strtolower($sheetData[$i]["H"])));
                    $license->setEmail($sheetData[$i]["I"]);
                    $license->setYear($sheetData[$i]["J"]);
                    $license->setType($sheetData[$i]["K"]);
                    $license->setPrimo($sheetData[$i]["L"]);
                    $license->setPractice($sheetData[$i]["M"]);
                    $license->setAptitude(ucfirst(strtolower($sheetData[$i]["N"])));
                    $license->setClub($sheetData[$i]["O"]);
                    $license->setDate($sheetData[$i]["P"]);
                    $license->setQualification($sheetData[$i]["Q"]);
                    $this->getEntityManager()->persist($license);
                }
                $connection = $this->getEntityManager()->getConnection();
                $platform = $connection->getDatabasePlatform();
                $connection->executeUpdate($platform->getTruncateTableSQL('license', true));
                $this->getEntityManager()->flush();
            } catch (Exception $exc) {
                return $response->withStatus(400, 'Error loading file: ' . $e->getMessage());
            }
        } else {
            return $response->withStatus(400, "Invalid Data");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET CURRENT USER LICENSES
    // -------------------------------------------------------------------------
    public function getMyLicense(Request $request, Response $response, $args) {
        $data = $this->getEntityManager()->getRepository(License::class)->findBy(array("email" => $_SESSION["user"]->getEmail()));       
        return $response->write(json_encode($data));
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET  LICENSES
    // -------------------------------------------------------------------------
    public function getLicenses(Request $request, Response $response, $args) {
        $search = isset($args["search"]) ? $args["search"] : null;
        if($search === null){
            $data = $this->getEntityManager()->getRepository(License::class)->findBy(array(), array("lastname" => "ASC"), 10);
        }else{
            $data = $this->getEntityManager()->createQuery("SELECT l FROM " . License::class . " l WHERE l.firstname LIKE :firstname OR l.lastname LIKE :lastname") // <= DQL, not SQL
                    ->setParameter("firstname", $search.'%')
                    ->setParameter("lastname", $search.'%')
                    ->setMaxResults(10)
                    ->getResult();
        }              
        return $response->write(json_encode($data));
    }

}
