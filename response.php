<?php

class Response{

    const FAIL = 'fail';
    const ERROR = 'error';
    const SUCCESS = 'success';


    function __construct(){

    }

    function _setHeaders($statusCode){
        http_response_code($statusCode);
        header('Content-Type: application/json');
    }

    function success($statusCode = 200, $data = null){
        $this->_setHeaders($statusCode);
        return json_encode([
            'status' => Response::SUCCESS,
            'data' => $data
        ]);
    }

    function fail($statusCode = 400, $data = null){
        $this->_setHeaders($statusCode);
        return json_encode([
            'status' => Response::FAIL,
            'data' => $data
        ]);
    }

    function error($statusCode = 500, $message = 'An error has ocurred'){
        $this->_setHeaders($statusCode);
        return json_encode([
            'status' => Response::ERROR,
            'message' => $message
        ]);
    }
}