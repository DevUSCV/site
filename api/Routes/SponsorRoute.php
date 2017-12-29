<?php

// POST
$app->post("/sponsor", App\Ressources\SponsorResource::class . ":createSponsor")
        ->add(new App\Middleware\Security\Admin());
// GET
$app->get("/sponsor", App\Ressources\SponsorResource::class . ":getSponsor");
// DELETE
$app->delete("/sponsor/{sponsor_id}", App\Ressources\SponsorResource::class . ":deleteSponsor")
        ->add(new App\Middleware\Security\admin());
