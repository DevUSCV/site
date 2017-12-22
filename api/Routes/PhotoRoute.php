<?php

// POST
$app->post("/photo", App\Ressources\PhotoResource::class . ":postPhoto")
        ->add(new App\Middleware\Security\Modo());
// PUT 
$app->put("/photo", App\Ressources\PhotoResource::class . ":updatePhoto")
        ->add(new App\Middleware\Security\Admin());
// GET
$app->get("/photo", App\Ressources\PhotoResource::class . ":getPhotos");
// DELETE
$app->delete("/photo/{photo_id}", App\Ressources\PhotoResource::class . ":deletePhoto")
        ->add(new App\Middleware\Security\Admin());