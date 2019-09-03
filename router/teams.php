<?php

use Slim\Http\Request;
use Slim\Http\Response;
require_once "middleware/mdl_teams.php";

$app->get("/teams", function (Request $request, Response $response) {
})->add($mdl_get_teams);
$app->post("/insert_team", function (Request $request, Response $response) {
})->add($mdl_insert_team);
$app->put("/update_team", function (Request $request, Response $response) {
})->add($mdl_update_team);
$app->delete("/delete_team", function (Request $request, Response $response) {
})->add($mdl_delete_team);