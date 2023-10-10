<?php

namespace Controller;

use JsonSerializable;

class ControllerAbstract
{
    protected function getJson(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            return "";
        }

        return file_get_contents('php://input');
    }

    protected function dispatchJsonResponse($data)
    {
        header("Content-Type: application/json");

        file_put_contents('php://output', json_encode($data));

        die();
    }
}
