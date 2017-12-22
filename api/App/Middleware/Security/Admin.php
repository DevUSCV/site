<?php

namespace App\Middleware\Security;

use App\Entity\User;
use Slim\Http\Request;
use Slim\Http\Response;

class Admin {

    public function __invoke(Request $request, Response $response, $next) {
        if (
                isset($_SESSION["user"]) &&
                $_SESSION["user"] instanceof User &&
                $_SESSION["user"]->getStatus() === "admin"
        ) {
            $response = $next($request, $response);
        } else {
            $response->write(false);
            $response = $response->withStatus(403, "Not Administrator");
        }
        return $response;
    }

}
