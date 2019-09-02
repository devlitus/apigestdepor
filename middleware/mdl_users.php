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
$mdl_detail_users = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::connect())):
    return $response->withJson(ConnectionDB::connect(), 500);
  endif;
  if (key_exists("error", Users::detailUser($request->getParsedBody()))):
    return $response->withJson(Users::detailUser($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Users::detailUser($request->getParsedBody()), 200);
};
$mdl_login = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::connect())):
    return $response->withJson(ConnectionDB::connect(), 500);
  endif;
  if (key_exists("error", Users::login($request->getParsedBody()))):
    return $response->withJson(Users::login($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Users::login($request->getParsedBody()), 200);
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
$mdl_update_user = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::connect())):
    return $response->withJson(ConnectionDB::connect(), 500);
  endif;
  /*if (key_exists("error", Users::updateUser($request, $request->getParsedBody()))):
    return $response->withJson(Users::updateUser($request, $request->getParsedBody()), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Users::updateUser($request, $request->getParsedBody()), 200);
};
$mdl_delete_user = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::connect())):
    return $response->withJson(ConnectionDB::connect(), 500);
  endif;
  /*if (key_exists("error", Users::deleteUser($request->getParsedBody()))):
    return $response->withJson(Users::deleteUser($request->getParsedBody()), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Users::deleteUser($request->getParsedBody()), 200);
};