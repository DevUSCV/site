<?php

namespace App\Middleware\Security;

use App\Entity\User;
use App\Config;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'App/Middleware/Security/recaptchalib.php';

class Captcha {

    public function __invoke(Request $request, Response $response, $next) {
        $grecaptcha = $request->getParam("grecaptcha");
        if (strlen($grecaptcha) > 0) {
            // reCaptcha info
            $secret = Config::GRECAPTCHA_SECRET_KEY;
            $remoteip = $_SERVER["REMOTE_ADDR"];
            $url = "https://www.google.com/recaptcha/api/siteverify";

            // Curl Request
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                'secret' => $secret,
                'response' => $grecaptcha,
                'remoteip' => $remoteip
            ));
            $curlData = curl_exec($curl);
            curl_close($curl);

            // Parse data
            $recaptcha = json_decode($curlData, true);
            
            if ($recaptcha["success"]) {
                $response = $next($request, $response);
            } else {
                $response->write(false);
                $response = $response->withStatus(403, "Invalid Captcha");
            }
        } else {
            $response->write(false);
            $response = $response->withStatus(403, "No Captcha");
        }
        return $response;
    }

}
