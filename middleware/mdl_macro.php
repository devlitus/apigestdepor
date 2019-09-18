<?php

use Connection\ConnectionDB;
use Connection\Macro;
use Connection\MaterialMacro;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_macro = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Macro::getMacro())):
    return $response->withJson(Macro::getMacro(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Macro::getMacro(), 200);
};
$mdl_get_material_macro = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", MaterialMacro::getMaterialMacro())):
    return $response->withJson(MaterialMacro::getMaterialMacro(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(MaterialMacro::getMaterialMacro(), 200);
};
$mdl_get_macro_planning = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", MaterialMacro::getMacroPlanning($request->getParsedBody()))):
    return $response->withJson(MaterialMacro::getMacroPlanning($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(MaterialMacro::getMacroPlanning($request->getParsedBody()), 200);
};
$mdl_insert_macro = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  /*if (key_exists("error", Macro::getMacro())):
    return $response->withJson(Macro::getMacro(), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Macro::insertMacro($request->getParsedBody()), 200);
};