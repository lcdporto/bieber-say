<?php

// web/index.php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();



header('Content-Type: application/json');
$app->get('/', function () use ($app) {
    return json_encode(['test' => 'a']);
});

$app->post('/', function() use ($app){

    $data = json_decode(file_get_contents('php://input'), true);

    $output = shell_exec('say "' . $data['message'] . '"');

    return json_encode([
        'message' => $output
    ]);
});

$app->run();