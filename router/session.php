<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once "middleware/mdl_session.php";
$app->get("/session", function (Request $request, Response $response) {
})->add($mdl_get_session);
$app->post("/insert_session", function (Request $request, Response $response) {
})->add($mdl_get_session);