<?php

// POST
$app->post("/blog/{blog_name}/post", App\Ressources\BlogPostResource::class . ":createBlogPost")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/blog/{blog_name}/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":getBlogPostById");
// PUT
$app->put("/blog/{blog_name}/post", App\Ressources\BlogPostResource::class . ":updateBlogPost")
        ->add(new App\Middleware\Security\Logged());
// DELETE
$app->delete("/blog/{blog_name}/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":deleteBlogPost");