<?php

use Connection\ConnectionDB;
use Connection\Users;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_users = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::connect())):
    return $response->withJson(ConnectionDB::connect(), 500);
  endif;
  if (key_exists("error", Users::getUsers())):
    return $response->withJson(Users::getUsers(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Users::getUsers(), 200);
};
$mdl_insert_user = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::connect())):
    return $response->withJson(ConnectionDB::connect(), 500);
  endif;
  /*if (key_exists("error", Users::insertUser($request, $request->getParsedBody()))):
    return $response->withJson(Users::insertUser($request, $request->getParsedBody()), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Users::insertUser($request, $request->getParsedBody()), 200);
};