<?php

// POST
$app->post("/reservation", App\Ressources\ReservationResource::class . ":createReservation")
        ->add(new App\Middleware\Security\Captcha());
// PUT 
// GET
$app->get("/reservation/valid/{token}", App\Ressources\ReservationResource::class . ":validReservation");
$app->get("/reservation", App\Ressources\ReservationResource::class . ":getMyReservation")
        ->add(new App\Middleware\Security\Logged());
// DELETE