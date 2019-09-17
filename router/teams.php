<?php
use Slim\Http\Request;
use Slim\Http\Response;
require_once "middleware/mdl_team.php";
$app->get("/teams", function (Request $request, Response $response){
})->add($mdl_get_team);
$app->post("/only_team", function (Request $request, Response $response){
})->add($mdl_only_team);
$app->post("/insert_team", function (Request $request, Response $response){
})->add($mdl_insert_team);
$app->put("/update_team", function (Request $request, Response $response){
})->add($mdl_update_team);
$app->post("/delete_team", function (Request $request, Response $response){
})->add($mdl_delete_team);