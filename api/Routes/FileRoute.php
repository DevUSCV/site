<?php

// POST
$app->post("/file", App\Ressources\FileResource::class . ":postFile")
        ->add(new App\Middleware\Security\Admin());
$app->post("/file/avisdecourse", App\Ressources\FileResource::class . ":postAvisDeCourse")
        ->add(new App\Middleware\Security\Admin());
// PUT 

// GET
$app->get("/file", App\Ressources\FileResource::class . ":getFile");
// DELETE
$app->delete("/file/{file_id}", App\Ressources\FileResource::class . ":deleteFile")
        ->add(new App\Middleware\Security\Admin());