<?php

// GET
$app->get("/city/{search}", App\Ressources\CityResource::class . ":getCityAutoComplete");
