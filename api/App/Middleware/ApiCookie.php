<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use \App\Entity\User;
use App\Ressources\UserResource;

class ApiCookie {

    private $cookieTime = 365 * 24 * 3600;

    public function __invoke(Request $request, Response $response, $next) {
//        //var_dump($_SESSION);
//        if(isset($_SESSION["user"]) && $_SESSION["user"] != null){
//            echo "ok";
//            setcookie('EMAIL', $_SESSION["user"]->email, time() + $this->cookieTime, null, null, false, true);  
//            setcookie('SESSION', sha1($_SESSION["user"]->password), time() + $this->cookieTime, null, null, false, true);  
//        }
//        
//        if(isset($_COOKIE["EMAIL"]) && isset($_COOKIE["SESSION"])){
//            $userResource = new UserResource(null);
//            $data = $userResource->getEntityManager()->getRepository('App\Entity\User')->findBy(Array("email" => $_COOKIE["EMAIL"]));
//            if ($data === null || $data == []) {
//                $user = $data[0];
//                if($userResource->checkLogin($_COOKIE["EMAIL"], $user->getPassword())){
//                    $_SESSION["user"] = $user;
//                }
//            }
//        }
        $response = $next($request, $response);
        //var_dump($_COOKIE);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
