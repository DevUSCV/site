<?php

// POST
$app->post("/user", App\Ressources\UserResource::class . ":createUser");
//GET
$app->get("/user/id/{user_id}", App\Ressources\UserResource::class . ":getUserById"); // TODO join to one
$app->get("/user/email/{email}", App\Ressources\UserResource::class . ":getUserByEmail");
// PUT
$app->put("/user/updatePassword", App\Ressources\UserResource::class . ":updatePassword");
// DELETE
$app->delete("/user/{user_id}", App\Ressources\UserResource::class . ":deleteUser");
// SESSION
$app->post("/login", App\Ressources\UserResource::class . ":login");
$app->get("/logout", App\Ressources\UserResource::class . ":logout");