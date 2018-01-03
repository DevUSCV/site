<?php

// POST
$app->post("/license", App\Ressources\LicenseResource::class . ":uploadLicense")
        ->add(new App\Middleware\Security\Admin());
// PUT 

// GET
$app->get("/license", App\Ressources\LicenseResource::class . ":getMyLicense")
        ->add(new App\Middleware\Security\Logged());
$app->get("/licenses", App\Ressources\LicenseResource::class . ":getLicenses")
        ->add(new App\Middleware\Security\Modo());
$app->get("/license/search/{search}", App\Ressources\LicenseResource::class . ":searchLicenses")
        ->add(new App\Middleware\Security\Modo());
$app->get("/license/search/", App\Ressources\LicenseResource::class . ":searchLicenses")
        ->add(new App\Middleware\Security\Modo());
// DELETE
