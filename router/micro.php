<?php

use Slim\Http\Request;
use Slim\Http\Response;

require "middleware/mdl_micro.php";
$app->post("/material_micro", function (Request $request, Response $response) {
})->add($mdl_macro_micro);