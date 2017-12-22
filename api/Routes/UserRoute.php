<?php

// POST
$app->post("/user", App\Ressources\UserResource::class . ":createUser")
        ->add(new App\Middleware\Security\Captcha());
//GET
$app->get("/user/{user}", App\Ressources\UserResource::class . ":getUser")
        ->add(new App\Middleware\Security\Modo());
$app->get("/user", App\Ressources\UserResource::class . ":getMe")
        ->add(new App\Middleware\Security\Logged());
$app->get("/user/valid/{token}", App\Ressources\UserResource::class . ":validUser");
// PUT
$app->put("/user/updatePassword", App\Ressources\UserResource::class . ":updatePassword");
// DELETE
$app->delete("/user/{user_id}", App\Ressources\UserResource::class . ":deleteUser")
        ->add(new App\Middleware\Security\Admin());
// SESSION
$app->post("/login", App\Ressources\UserResource::class . ":login");
$app->get("/logout", App\Ressources\UserResource::class . ":logout");
