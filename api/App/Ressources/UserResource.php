<?php

namespace App\Ressources;

use App\Entity\User;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class UserResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET USER BY ID
    // -------------------------------------------------------------------------
    public function getUserById(Request $request, Response $response, $args) {
        $user_id = intval($args["user_id"]);
        if ($user_id === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->find('App\Entity\User', $user_id);
        }
        if ($data === null) {
            return $response->withStatus(404, "User Not Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET USER BY EMAIL
    // -------------------------------------------------------------------------
    public function getUserByEmail(Request $request, Response $response, $args) {
        $email = $args["email"];
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        if (preg_match($pattern, $email) === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->getRepository('App\Entity\User')->findBy(Array("email" => $email));
        }
        if ($data === null || $data == []) {
            $response = $response->withStatus(404, "User Not Found");
        } else {
            $response->write(json_encode($data[0]));
        }

        return $response;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE USER
    // -------------------------------------------------------------------------
    public function createUser(Request $request, Response $response, $args) {
        $user = new User();
        $firstname = $request->getParam("firstname");
        $lastname = $request->getParam("lastname");
        $birth_date = $request->getParam("birth_date");
        $phone = $request->getParam("phone");
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        if($firstname && $lastname){
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setBirth_date($birth_date);
            $user->setPhone($phone);
            if($email && $password){
                $user->setEmail($email);
                $user->setPassword($this->hashPassword($password));
            }            
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush($user);
            $response->write(json_encode($user));
            // TODO SEND MAIL
        }else{
            $response->write("");
            $response = $response->withStatus(400, "Invalid User");
        }       
        return $response;        
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE USER
    // -------------------------------------------------------------------------
    public function deleteUser(Request $request, Response $response, $args) {
        $user_id = intval($args["user_id"]);
        if($user_id > 0){
            $comment = $this->getEntityManager()->find(User::class, $user_id);
            if($comment){
                $this->getEntityManager()->remove($comment);
                $this->getEntityManager()->flush();
            }else{
                return $response->withStatus(404, "User Not Found");
            }
        }else{
            return $response->withStatus(400, "Invalid User Id");
        }
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- LOGIN USER
    // -------------------------------------------------------------------------
    public function login(Request $request, Response $response, $args) {
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        $user = $this->checkLogin($email, $password);
                
        if ($user) {
            $response->write(true);
            $_SESSION["user"] = $user;
        } else {
            return $response->withStatus(401, "Wrong Login");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- LOGOUT USER
    // -------------------------------------------------------------------------
    public function logout(Request $request, Response $response, $args) {
        session_destroy();
        return $response->write(true);
    }

    public function updatePassword(Request $request, Response $response, $args) {
        $email = $request->getParam('email');
        $oldPassword = $request->getParam("oldPassword");
        $newPassword = $request->getParam("newPassword");
        $user = $this->checkLogin($email, $oldPassword);
        if ($user instanceof User) {
            $user->setPassword($this->hashPassword($newPassword));
            $this->getEntityManager()->flush($user);
            $_SESSION["user"] = $user;
        } else {
            $response = $response->withStatus(401, "Wrong Login");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- ENCRYPT PASSWORD
    // -------------------------------------------------------------------------
    private function hashPassword(String $password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CHECK PASSWORD
    // -------------------------------------------------------------------------
    private function checkPassword(String $password, String $hash) {
        return password_verify($password, $hash);
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CHECK EMAIL WITH PASSWORD
    // -------------------------------------------------------------------------
    public function checkLogin(String $email, String $password) {
        if ($email && $password) {
            $data = $this->getEntityManager()->getRepository('App\Entity\User')->findBy(Array("email" => $email));
            if ($data === null || $data == []) {
                return false;
            } else {
                $user = $data[0];
                if ($this->checkPassword($password, $user->getPassword())) {
                    return $user;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

}
