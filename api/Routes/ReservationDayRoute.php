<?php

// POST
// PUT 
// GET
$app->get("/reservation/{year}/{month}/{day}", App\Ressources\ReservationDayResource::class . ":getReservationDay")
        ->add(new App\Middleware\Security\Modo());
$app->get("/reservations/{number_of_days}", App\Ressources\ReservationDayResource::class . ":getReservationDays")
        ->add(new App\Middleware\Security\Modo());
// DELETE