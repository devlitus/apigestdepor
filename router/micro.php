<?php

use Slim\Http\Request;
use Slim\Http\Response;

require "middleware/mdl_micro.php";

$app->get("/micro", function (Request $request, Response $response) {
})->add($mdl_get_micro);
$app->post("/material_micro", function (Request $request, Response $response) {
})->add($mdl_get_material_micro);
$app->post("/insert_micro", function (Request $request, Response $response) {
})->add($mdl_insert_micro);