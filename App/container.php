<?php

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $dir = dirname(__DIR__);
    $view = new Slim\Views\Twig($dir . "/App/View", [
        'cache' => false, //$dir . "/tmp/cache",
        'debug' => true
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

$container["user"] = (isset($_SESSION["user"]) ? $_SESSION["user"] : false);