<?php

// web/index.php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/response.php';
require_once __DIR__ . '/tts.php';
require_once __DIR__ . '/TemplateReader.php';


$app = new Silex\Application();

$app->response = new Response();
$app->tts = new Say();

$app->error(function (\Exception $e, $code) {
    return $app->response->error($code, $e->getMessage());
});

try{
    $app->input = json_decode(file_get_contents('php://input'), true);
}catch (Exception $e){
    $app->input = [];
}



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

$app->get('/templates', function() use($app){
    $templates = TemplateReader::getInstance()->getList();
    return $app->response->success(200, $templates);
});

$app->get('/templates/{templateName}', function($templateName) use($app){
    if(TemplateReader::getInstance()->exists($templateName)){
        TemplateReader::getInstance()->load($templateName);

        $bashResponse = $app->tts->say(TemplateReader::getInstance()->getMessage($_GET));
        return $app->response->success(200, $bashResponse);
    }else{
        return $app->response->fail(404, 'Template not found');
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
        return $app->response->fail(403, $fail);
    }

    TemplateReader::getInstance()->save($app->input['name'], $app->input['message']);
    return $app->response->success(200, 'template created');
});


$app->run();