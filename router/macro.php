<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once "middleware/mdl_macro.php";

$app->get("/macro", function (Request $request, Response $response) {
})->add($mdl_get_macro);
$app->get("/material_macro", function (Request $request, Response $response) {
})->add($mdl_get_material_macro);
$app->post("/insert_macro", function (Request $request, Response $response) {
})->add($mdl_insert_macro);