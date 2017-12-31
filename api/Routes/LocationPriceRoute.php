<?php

// POST
$app->post("/location", App\Ressources\LocationPriceResource::class . ":createLocationPrice")
        ->add(new App\Middleware\Security\Admin());
// PUT 
$app->post("/location/update", App\Ressources\LocationPriceResource::class . ":updateLocationPrice") // PUT REQUEST DO NOT ACCEPT FILE UPLOAD
        ->add(new App\Middleware\Security\Admin());
// GET
$app->get("/location", App\Ressources\LocationPriceResource::class . ":getLocationPrice");
$app->get("/location/{location_price_id}", App\Ressources\LocationPriceResource::class . ":getLocationPriceById")
        ->add(new App\Middleware\Security\Admin());
// DELETE
$app->delete("/location/{location_price_id}", App\Ressources\LocationPriceResource::class . ":deleteLocationPrice")
        ->add(new App\Middleware\Security\Admin());