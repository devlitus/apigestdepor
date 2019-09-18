<?php

use Connection\ConnectionDB;
use Connection\Micros;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_micro = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Micros::getMicros())):
    return $response->withJson(Micros::getMicros(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Micros::getMicros(), 200);
};
$mdl_get_material_micro = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Micros::getMaterialMicro($request->getParsedBody()))):
    return $response->withJson(Micros::getMaterialMicro($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Micros::getMaterialMicro($request->getParsedBody()), 200);
};
$mdl_insert_micro = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  /*if (key_exists("error", MaterialMacro::getMaterialMacro())):
    return $response->withJson(MaterialMacro::getMaterialMacro(), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Micros::insertMicro($request->getParsedBody()), 200);
};