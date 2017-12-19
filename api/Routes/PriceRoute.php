<?php

// POST

// PUT 

// GET
$app->get("/price/{category}", App\Ressources\PriceResource::class . ":getPriceByCategory");
// DELETE