<?php

// POST
$app->post("/blog", App\Ressources\BlogResource::class . ":createBlog");
// GET
$app->get("/blog/{blog_name}", App\Ressources\BlogResource::class . ":getBlogByName");
// PUT 
$app->put("/blog", App\Ressources\BlogResource::class . ":updateBlog");
// DELETE
$app->delete("/blog/{blog_id}", App\Ressources\BlogResource::class . ":deleteBlog");