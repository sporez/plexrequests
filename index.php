<?php

require __DIR__ . '/vendor/autoload.php';

$settings =  [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new Slim\App($settings);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $templates = __DIR__ . '/templates/';
    $cache = __DIR__ . '/tmp/views/';

    $view = new Slim\Views\Twig($templates, [cache=>'false']);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig');
})->setName('index');

$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile.twig', [
        'name' => $args['name']
    ]);
})->setName('profile');

$app->run();