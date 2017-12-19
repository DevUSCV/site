<?php

// POST
$app->post("/location", App\Ressources\LocationPriceResource::class . ":createLocationPrice");
// PUT 
// GET
$app->get("/location", App\Ressources\LocationPriceResource::class . ":getLocationPrice");
// DELETE