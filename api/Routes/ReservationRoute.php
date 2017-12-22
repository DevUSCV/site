<?php

// POST
$app->post("/reservation", App\Ressources\ReservationResource::class . ":createReservation")
        ->add(new App\Middleware\Security\Captcha());
// PUT 
// GET

// DELETE