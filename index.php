<?php

// web/index.php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/response.php';
require_once __DIR__ . '/tts.php';


$app = new Silex\Application();

$app->response = new Response();
$app->tts = new Say();

$app->error(function (\Exception $e, $code) {
    return $app->response->error($code, $e->getMessage());
});

$app->input = json_decode(file_get_contents('php://input'), true);



$app->get('/', function () use ($app) {
    return $app->response->success(200, 'API online and running fine');
});

$app->post('/', function() use ($app){
    if(!isset($app->input['message'])){
        return $app->response->fail(400, [
            'message' => 'Argument is missing'
        ]);
    }

    $bashResponse = $app->tts->say($app->input['message']);
    return $app->response->success(200, $bashResponse);
});



$app->run();