<?php

require __DIR__ . '/vendor/autoload.php';

use App\SQLiteConnection;
use App\SQLiteInsert;
use App\SQLiteGet;

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

    $view = new Slim\Views\Twig($templates, ['cache' => false]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

//ROUTES

//REQUESTS
$app->get('/requests', function ($request, $response, $args) {
    $pdo = (new SQLiteConnection())->connect();
    $sqlite = new SQLiteGet($pdo);

    $res = $sqlite->getRequests();
    
    return $response->getBody()->write($res);
})->setName('getRequests');

$app->get('/requests/{rid}', function ($request, $response, $args) {

    $pdo = (new SQLiteConnection())->connect();
    $sqlite = new SQLiteGet($pdo);

    $rid = filter_var($args['rid'], FILTER_SANITIZE_NUMBER_INT);
    $res = $sqlite->getRequests($rid);
    
    return $response->getBody()->write($res);
})->setName('getRequest');

$app->post('/requests', function ($request, $response, $args) {
    $data = $request->getParsedBody();
    $req_data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $req_data['uid'] = filter_var($data['uid'], FILTER_SANITIZE_STRING);

    $pdo = (new SQLiteConnection())->connect();
    $sqlite = new SQLiteInsert($pdo);
    $res = $sqlite->insertRequest($req_data['name'], $req_data['uid']);


    if($res)
        return $response->getBody()->write($res);
})->setName('newRequest');

//USERS
$app->get('/users', function ($request, $response, $args) {

    $pdo = (new SQLiteConnection())->connect();
    $sqlite = new SQLiteGet($pdo);

    $res = $sqlite->getUsers();
    
    return $response->getBody()->write($res);
})->setName('getUsers');

$app->get('/users/{uid}', function ($request, $response, $args) {

    $pdo = (new SQLiteConnection())->connect();
    $sqlite = new SQLiteGet($pdo);

    $uid = filter_var($args['uid'], FILTER_SANITIZE_NUMBER_INT);
    $res = $sqlite->getUsers($uid);
    
    return $response->getBody()->write($res);
})->setName('getUser');

// $app->get('/', function ($request, $response, $args) {
//     return $this->view->render($response, 'index.twig');
// })->setName('index');

// $app->get('/hello/{name}', function ($request, $response, $args) {
//     return $this->view->render($response, 'profile.twig', [
//         'name' => $args['name']
//     ]);
// })->setName('profile');

$app->run();