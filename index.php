<?php

// web/index.php
require_once 'vendor/autoload.php';
require_once 'tts.php';
require_once 'TemplateReader.php';

const SUCCESS = 'success';
const FAIL = 'fail';
const ERROR = 'error';


ini_set('display_errors', 1);
error_reporting(-1);
//ErrorHandler::register();
if ('cli' !== php_sapi_name()) {
    //ExceptionHandler::register();
}



$app = new Silex\Application();


$app['debug'] = true;


$app->tts = new GNUStep();



try{
    $app->input = json_decode(file_get_contents('php://input'), true);
}catch (Exception $e){
    $app->input = [];
}


$app->get('/', function () use ($app) {
    return $app->json([
        'status' => SUCCESS,
        'message' => 'API up and running'
    ], 200);
});

$app->post('/', function() use ($app){
    if(!isset($app->input['message'])){
        return $app->json([
            'status' => FAIL,
            'message' => 'Argument is missing'
        ], 400);
    }

    $bashResponse = $app->tts->say($app->input['message']);
    return $app->json([
        'status' => SUCCESS,
        'data' => $bashResponse
    ]);
});

$app->get('/templates/', function() use($app){
    $templates = TemplateReader::getInstance()->getList();
    return $app->json([
        'status' => SUCCESS,
        'data' => $templates
    ]);
});

$app->get('/templates/{templateName}', function($templateName) use($app){
    if(TemplateReader::getInstance()->exists($templateName)){
        TemplateReader::getInstance()->load($templateName);

        $bashResponse = $app->tts->say(TemplateReader::getInstance()->getMessage($_GET));
        return $app->json([
            'status' => SUCCESS,
            'message' => $bashResponse
        ]);
    }else{
        return $app->json([
            'status' => FAIL,
            'data' => 'Template not found'
        ]);
    }

});

$app->post('/templates', function() use($app){
    $requiredArguments = ['name', 'message'];
    $fail = [];
    foreach($requiredArguments as $argumentName){
        if(!isset($app->input[$argumentName]) || empty($app->input[$argumentName])){
            $fail[$argumentName] = 'Missing Argument';
        }
    }
    if(!empty($fail)){
        return $app->json([
            'status' => FAIL,
            'data' => $fail
        ]);
    }

    TemplateReader::getInstance()->save($app->input['name'], $app->input['message']);
    return $app->json([
        'status' => SUCCESS,
        'data' => 'template created'
    ], 201);
});


$app->run();