<?php

// POST
$app->post("/article/{article_id}/comment", App\Ressources\ArticleCommentResource::class . ":createArticleComment")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/article/{article_id}/comment", App\Ressources\ArticleCommentResource::class . ":getArticleCommentsByArticleId");
// DELETE
$app->delete("/article/{article_id}/comment/{article_comment_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticleComment");