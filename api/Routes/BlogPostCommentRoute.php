<?php

// POST
$app->post("/blog/{blog_name}/post/{blog_post_id}/comment", App\Ressources\BlogPostCommentResource::class . ":createBlogPostComment")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/blog/{blog_name}/post/{blog_post_id}/comment", App\Ressources\BlogPostCommentResource::class . ":getBlogPostCommentByPostId");
// DELETE
$app->delete("/blog/{blog_name}/post/{blog_post_id}/comment/{blog_post_comment_id}", App\Ressources\BlogPostCommentResource::class . ":deleteBlogPostComment");