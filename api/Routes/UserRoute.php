<?php

// POST
$app->post("/user", App\Ressources\UserResource::class . ":createUser")
        ->add(new App\Middleware\Security\Captcha());
$app->post("/user/recoverpassword", App\Ressources\UserResource::class . ":recoverUserPassword");
$app->post("/user/recoveredpassword", App\Ressources\UserResource::class . ":recoveredUserPassword");
$app->post("/user/contact", App\Ressources\UserResource::class . ":contactUser")
        ->add(new App\Middleware\Security\Modo());
//GET
$app->get("/user/{user}", App\Ressources\UserResource::class . ":getUser")
        ->add(new App\Middleware\Security\Modo());
$app->get("/user/search/{search}", App\Ressources\UserResource::class . ":searchUser")
        ->add(new App\Middleware\Security\Modo());
$app->get("/user/search/", App\Ressources\UserResource::class . ":searchUser")
        ->add(new App\Middleware\Security\Modo());
$app->get("/user", App\Ressources\UserResource::class . ":getMe")
        ->add(new App\Middleware\Security\Logged());
$app->get("/user/valid/{token}", App\Ressources\UserResource::class . ":validUser");
// PUT
$app->put("/user/updatepassword", App\Ressources\UserResource::class . ":updateUserPassword");
$app->put("/user", App\Ressources\UserResource::class . ":updateMe")
        ->add(new App\Middleware\Security\Logged());
$app->put("/user/updatestatus", App\Ressources\UserResource::class . ":updateUserStatus")
        ->add(new App\Middleware\Security\Admin());
// DELETE
$app->delete("/user/{user_id}", App\Ressources\UserResource::class . ":deleteUser")
        ->add(new App\Middleware\Security\Admin());
$app->delete("/user", App\Ressources\UserResource::class . ":deleteMe")
        ->add(new App\Middleware\Security\Logged());
// SESSION
$app->post("/login", App\Ressources\UserResource::class . ":login");
$app->get("/logout", App\Ressources\UserResource::class . ":logout");
