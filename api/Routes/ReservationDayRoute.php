<?php

// POST
// PUT 
// GET
$app->get("/reservation/{year}/{month}/{day}", App\Ressources\ReservationDayResource::class . ":getReservationDay");
// DELETE