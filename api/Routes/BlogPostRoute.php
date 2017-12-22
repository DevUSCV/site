<?php

// POST
$app->post("/blog/{blog_name}/post", App\Ressources\BlogPostResource::class . ":createBlogPost")
        ->add(new App\Middleware\Security\Modo());
// GET
$app->get("/blog/{blog_name}/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":getBlogPostById");
// PUT
$app->put("/blog/{blog_name}/post", App\Ressources\BlogPostResource::class . ":updateBlogPost")
        ->add(new App\Middleware\Security\Admin());
// DELETE
$app->delete("/blog/{blog_name}/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":deleteBlogPost")
        ->add(new App\Middleware\Security\Admin());
