<?php

// POST
$app->post("/blog", App\Ressources\BlogResource::class . ":createBlog")
        ->add(new App\Middleware\Security\Admin());
// GET
$app->get("/blog/{blog_name}", App\Ressources\BlogResource::class . ":getBlogByName");
// PUT 
$app->put("/blog", App\Ressources\BlogResource::class . ":updateBlog")
        ->add(new App\Middleware\Security\Admin());;
// DELETE
$app->delete("/blog/{blog_id}", App\Ressources\BlogResource::class . ":deleteBlog")
        ->add(new App\Middleware\Security\Admin());;