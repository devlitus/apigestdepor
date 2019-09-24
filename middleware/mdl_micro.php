<?php

use Connection\ConnectionDB;
use Connection\MaterialMicro;
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
$mdl_get_material_micro = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", MaterialMicro::getMaterialMicro($request->getParsedBody()))):
    return $response->withJson(MaterialMicro::getMaterialMicro($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(MaterialMicro::getMaterialMicro($request->getParsedBody()), 200);
};
$mdl_insert_micro = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  /*if (key_exists("error", Micros::insertMicro($request->getParsedBody()))):
    return $response->withJson(Micros::insertMicro($request->getParsedBody()), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Micros::insertMicro($request->getParsedBody()), 200);
};
