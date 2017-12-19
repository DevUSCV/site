<?php

// POST
$app->post("/photo", App\Ressources\PhotoResource::class . ":postPhoto");
// PUT 
$app->put("/photo", App\Ressources\PhotoResource::class . ":updatePhoto");
// GET
$app->get("/photo", App\Ressources\PhotoResource::class . ":getPhotos");
// DELETE
$app->delete("/photo/{photo_id}", App\Ressources\PhotoResource::class . ":deletePhoto");