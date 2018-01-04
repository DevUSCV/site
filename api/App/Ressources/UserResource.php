<?php

namespace App\Ressources;

use App\Entity\User;
use App\AbstractResource;
use App\Ressources\EmailRessource;
use Slim\Http\Request;
use Slim\Http\Response;

class UserResource extends AbstractResource {

    private $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- GET USER BY ID OR EMAIL
// -------------------------------------------------------------------------
    public function getUser(Request $request, Response $response, $args) {
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        $user_id = intval($args["user"]);
        $email = $args["user"];

        if ($user_id !== 0) {
            $data = $this->getEntityManager()->find('App\Entity\User', $user_id);
        } elseif (preg_match($pattern, $email) === 1) {
            $data = $this->getEntityManager()->getRepository('App\Entity\User')->findBy(Array("email" => $email));
        } else {
            $data = null;
        }
        if ($data === null) {
            return $response->withStatus(404, "User Not Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- SEARCH USER
// -------------------------------------------------------------------------
    public function searchUser(Request $request, Response $response, $args) {
        $search = isset($args["search"]) ? $args["search"] : "";

        $data = $this->getEntityManager()->getRepository(User::class)->createQueryBuilder("u")
                        ->orWhere("u.firstname LIKE :firstname")
                        ->orWhere("u.lastname LIKE :lastname")
                        ->andWhere("u.status IS NOT NULL")
                        ->setParameter("firstname", "%" . $search . "%")
                        ->setParameter("lastname", "%" . $search . "%")
                        ->orderBy("u.lastname", "ASC")
                        ->setMaxResults(20)
                        ->getQuery()->getResult();
        return $response->write(json_encode($data));
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- GET LOGGED USER
// -------------------------------------------------------------------------
    public function getMe(Request $request, Response $response, $args) {
        return $response->write(
                        json_encode(
                                $this->getEntityManager()
                                        ->find(User::class, $_SESSION["user"]->getUser_id()
        )));
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- UPDATE LOGGED USER
// -------------------------------------------------------------------------
    public function updateMe(Request $request, Response $response, $args) {
        $firstname = $request->getParam("firstname");
        $lastname = $request->getParam("lastname");
        $phone = $request->getParam("phone");
        $birth_date = $request->getParam("birth_date");

        if (
                strlen($firstname) >= 3 &&
                strlen($lastname) >= 3
        ) {
            $user = $this->getEntityManager()->find(User::class, $_SESSION["user"]->getUser_id());
            $user->setFirstname(ucwords($firstname));
            $user->setLastname(ucwords($lastname));
            $user->setPhone((strlen($phone) >= 10) ? $phone : null);
            $user->setBirth_date((strlen($phone) >= 8 && strlen($phone) <= 10) ? new \DateTime($birth_date) : null);
            $this->getEntityManager()->flush($user);
            $_SESSION["user"] = $user;
            return $response->write(true);
        } else {
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- UPDATE USER STATUS
// -------------------------------------------------------------------------
    public function updateUserStatus(Request $request, Response $response, $args) {
        $user_id = intval($request->getParam("user_id"));
        $status = $request->getParam("status");

        if (
                $user_id > 0 &&
                ($status == "modo" || $status == "active")
        ) {
            $user = $this->getEntityManager()->find(User::class, $user_id);
            if ($user instanceof User) {
                $user->setStatus($status);
                $this->getEntityManager()->flush($user);
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(400, "User Not Found");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- CREATE USER
// -------------------------------------------------------------------------
    public function createUser(Request $request, Response $response, $args) {
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

        $user = new User();
        $firstname = $request->getParam("firstname");
        $lastname = $request->getParam("lastname");
        $birth_date = $request->getParam("birth_date");
        $phone = $request->getParam("phone");
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        if (
                strlen($firstname) >= 3 &&
                strlen($lastname) >= 3 &&
                preg_match($pattern, $email) === 1 &&
                strlen($password) >= 6
        ) {
            if ($this->getEntityManager()->getRepository(User::class)->findOneBy(array("email" => $email))) {
                $response->write(false);
                return $response->withStatus(400, "Email Already In Use");
            }
            $user->setSubscribe_date(new \DateTime("NOW"));
            $user->setFirstname(ucwords($firstname));
            $user->setLastname(ucwords($lastname));
            $user->setBirth_date($birth_date);
            $user->setPhone($phone);
            $user->setToken(bin2hex(openssl_random_pseudo_bytes(128)));
            $user->setEmail($email);
            $user->setPassword($this->hashPassword($password));
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush($user);
            return $response->write(EmailRessource::newUser($user));
        } else {
            $response->write(false);
            return $response = $response->withStatus(400, "Invalid User");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- CHANGE USER PASSWORD
// -------------------------------------------------------------------------
    public function updateUserPassword(Request $request, Response $response, $args) {
        $old_password = $request->getParam('old_password');
        $new_password = $request->getParam('new_password');
        $confirm_new_password = $request->getParam('confirm_new_password');
        if (
                strlen($old_password) >= 6 &&
                strlen($new_password) >= 6 &&
                strcmp($old_password, $confirm_new_password)
        ) {
            $user = $this->checkLogin($_SESSION["user"]->getEmail(), $old_password);
            if ($user instanceof User) {
                $user->setPassword($this->hashPassword($new_password));
                $this->getEntityManager()->flush($user);
                EmailRessource::userPasswordChanged($user);
                session_destroy();
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(400, "Invalid Password");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- RECHOVER USER PASSWORD
// -------------------------------------------------------------------------
    public function recoverUserPassword(Request $request, Response $response, $args) {
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        $email = $request->getParam('email');
        if (
                preg_match($pattern, $email) === 1
        ) {
            $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(array("email" => $email));
            if ($user instanceof User) {
                $user->setToken(bin2hex(openssl_random_pseudo_bytes(128)));
                $this->getEntityManager()->flush($user);
                EmailRessource::userRecoverPassword($user);
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(400, "User Not Found");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Email");
        }
    }

    public function recoveredUserPassword(Request $request, Response $response, $args) {
        $token = $request->getParam("token");
        $new_password = $request->getParam("new_password");
        $confirm_new_password = $request->getParam("confirm_new_password");
        if (
                strlen($token) === 256 &&
                strlen($new_password) >= 6 &&
                strcmp($new_password, $confirm_new_password) === 0
        ) {
            $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(array("token" => $token));
            if ($user instanceof User) {
                $user->setPassword($this->hashPassword($new_password));
                $user->setToken(null);
                $this->getEntityManager()->flush($user);
                EmailRessource::userPasswordChanged($user);
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(400, "Invalid Token");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- DELETE USER
// -------------------------------------------------------------------------
    public function deleteUser(Request $request, Response $response, $args) {
        $user_id = intval($args["user_id"]);
        $confirm_delete_user_check1 = $request->getParam("confirm_delete_user_check1") === 'true';
        $confirm_delete_user_check2 = $request->getParam("confirm_delete_user_check2") === 'true';
        if (
                $user_id > 0 &&
                $confirm_delete_user_check1 &&
                $confirm_delete_user_check2 
        ) {
            $user = $this->getEntityManager()->find(User::class, $user_id);
            if ($user instanceof User) {
                EmailRessource::deletedUser($user);
                $this->getEntityManager()->remove($user);
                $this->getEntityManager()->flush();
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(404, "User Not Found");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid User Id");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- DELETE CURRENT USER
// -------------------------------------------------------------------------
    public function deleteMe(Request $request, Response $response, $args) {
        $confirm_delete_me_check1 = $request->getParam("confirm_delete_me_check1") === 'true';
        $confirm_delete_me_check2 = $request->getParam("confirm_delete_me_check2") === 'true';
        if (
                $confirm_delete_me_check1 &&
                $confirm_delete_me_check2 &&
                $_SESSION["user"]->getStatus() !== "admin"
        ) {
            $user = $this->getEntityManager()->find(User::class ,$_SESSION['user']->getUser_id());
            if ($user instanceof User) {
                EmailRessource::deletedUser($user);
                $this->getEntityManager()->remove($user);
                $this->getEntityManager()->flush();
                session_destroy();
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(404, "User Not Found");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid User Id");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- VALID USER
// -------------------------------------------------------------------------
    public function validUser(Request $request, Response $response, $args) {
        $token = $args["token"];
        if (strlen($token) === 256) {
            $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(array("token" => $token));
            if ($user instanceof User) {
                $user->setStatus("active");
                $user->setToken(null);
                $this->getEntityManager()->flush($user);
                EmailRessource::verifiedUser($user);
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(400, "Account Already Activated");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Token");
        }
    }

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- LOGIN USER
// -------------------------------------------------------------------------
    public function login(Request $request, Response $response, $args) {
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        $user = $this->checkLogin($email, $password);
        if ($user instanceof User && $user->getStatus() !== null) {
            $response->write(true);
            $_SESSION["user"] = $user;
        } else {
            return $response->write(false)->withStatus(401, "Wrong Login");
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

// -------------------------------------------------------------------------
// ------------------------------------------------------------------------- Contact USER
// -------------------------------------------------------------------------
    public function contactUser(Request $request, Response $response, $args) {
        $user_id = intval($request->getParam('user_id'));
        $object = $request->getParam('object');
        $message = $request->getParam('message');
        if (
                $user_id > 0 &&
                strlen($object) >= 10 &&
                strlen($message) >= 10
        ) {
            $user = $this->getEntityManager()->find(User::class, $user_id);
            if ($user instanceof User) {
                EmailRessource::contactUser($user, $object, $message);
                return $response->write(true);
            } else {
                return $response->write(false)->withStatus(400, "User Not Found");
            }
        } else {
            return $response->write(false)->withStatus(400, "Invalid Data");
        }
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
