<?php

// POST
$app->post("/location", App\Ressources\LocationPriceResource::class . ":createLocationPrice")
        ->add(new App\Middleware\Security\Admin());
// PUT 
// GET
$app->get("/location", App\Ressources\LocationPriceResource::class . ":getLocationPrice");
// DELETE