<?php

namespace App\Middleware\Security;

use App\Entity\User;
use Slim\Http\Request;
use Slim\Http\Response;

class Modo {

    public function __invoke(Request $request, Response $response, $next) {
        if (
                isset($_SESSION["user"]) &&
                $_SESSION["user"] instanceof User &&
                ($_SESSION["user"]->getStatus() === "admin" || $_SESSION["user"]->getStatus() === "modo")
        ) {
            $response = $next($request, $response);
        } else {
            $response->write(false);
            $response = $response->withStatus(403, "Not Moderator");
        }
        return $response;
    }

}
