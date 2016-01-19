<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;
$app->post('/', function (Request $request, Response $response) {

    parse_str(file_get_contents('php://input'), $output);

    $msg = trim(str_replace($output['trigger_word'], '', $output['text']));

    $consoleOutput = shell_exec('say "' . $msg . '"');

    $response->getBody()->write(json_encode([
        'status' => 'success',
        'message' => $msg,
        'console' => $consoleOutput
    ]));
    return $response;
});
$app->run();