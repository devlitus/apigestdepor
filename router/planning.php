<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once "middleware/mdl_planning.php";
$app->get("/planning", function (Request $request, Response $response) {
})->add($mdl_get_planning);
$app->post("/insert_planning", function (Request $request, Response $response) {
})->add($mdl_insert_planning);
