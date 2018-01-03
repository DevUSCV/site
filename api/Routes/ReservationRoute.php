<?php

// POST
$app->post("/reservation", App\Ressources\ReservationResource::class . ":createReservation")
        ->add(new App\Middleware\Security\Captcha());
$app->post("/reservation/sendmail", App\Ressources\ReservationResource::class . ":mailReservation")
        ->add(new App\Middleware\Security\Modo());
// PUT 
$app->put("/reservation/confirm", App\Ressources\ReservationResource::class . ":confirmReservation")
        ->add(new App\Middleware\Security\Modo());
// GET
$app->get("/reservation/{reservation_id}", App\Ressources\ReservationResource::class . ":getReservationById")
        ->add(new App\Middleware\Security\Modo());
$app->get("/reservation/valid/{token}", App\Ressources\ReservationResource::class . ":validReservation");
$app->get("/reservation", App\Ressources\ReservationResource::class . ":getMyReservation");
$app->get("/reservation/name/{search}", App\Ressources\ReservationResource::class . ":searchReservationByFullName")
        ->add(new App\Middleware\Security\Modo());
// DELETE
$app->delete("/reservation/{reservation_id}", App\Ressources\ReservationResource::class . ":deleteReservation")
        ->add(new App\Middleware\Security\Modo());