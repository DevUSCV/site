<?php

// POST
$app->post("/article", App\Ressources\ArticleResource::class . ":createArticle")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/article/{article}", App\Ressources\ArticleResource::class . ":getArticle");
// PUT
$app->put("/article/{article_id}", App\Ressources\ArticleResource::class . ":updateArticle")
        ->add(new App\Middleware\Security\Logged());
// DELETE
$app->delete("/article/{article_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticle");