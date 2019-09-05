<?php

use Connection\ConnectionDB;
use Connection\Planning;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_planning = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Planning::getPlanning())):
    return $response->withJson(Planning::getPlanning(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Planning::getPlanning());
};
$mdl_insert_planning = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  /*if (key_exists("error", Planning::insertPlanning($request->getParsedBody()))):
    return $response->withJson(Planning::insertPlanning($request->getParsedBody()));
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Planning::insertPlanning($request->getParsedBody()), 201);
};