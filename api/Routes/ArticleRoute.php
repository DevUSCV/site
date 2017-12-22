<?php

// POST
$app->post("/article", App\Ressources\ArticleResource::class . ":createArticle")
        ->add(new App\Middleware\Security\Admin());
// GET
$app->get("/article/{article}", App\Ressources\ArticleResource::class . ":getArticle");
// PUT
$app->put("/article/{article_id}", App\Ressources\ArticleResource::class . ":updateArticle")
        ->add(new App\Middleware\Security\Admin());
// DELETE
$app->delete("/article/{article_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticle")
        ->add(new App\Middleware\Security\Admin());