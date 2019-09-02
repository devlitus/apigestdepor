<?php

use Slim\App;
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

require_once "config/config.php";
require_once "middleware/mdl_users.php";
$app = new App($config);
$app->get('/users', function (Request $request, Response $response) {
})->add($mdl_get_users);
$app->post('/detail_user', function (Request $request, Response $response) {
})->add($mdl_detail_users);
$app->post('/login', function (Request $request, Response $response) {
})->add($mdl_login);
$app->post("/insert_user", function (Request $request, Response $response) {
})->add($mdl_insert_user);
$app->post("/update_user", function (Request $request, Response $response) {
})->add($mdl_update_user);
$app->post("/delete_user", function (Request $request, Response $response) {
})->add($mdl_delete_user);
$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
