<?php

// PUT
$app->put("/user/address", App\Ressources\AddressResource::class . ":updateCurrentUserAddress")
        ->add(new App\Middleware\Security\Logged());
$app->put("/user/{user_id}/address", App\Ressources\AddressResource::class . ":updateUserAddress");