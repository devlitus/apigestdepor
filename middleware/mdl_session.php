<?php

use Connection\ConnectionDB;
use Connection\MaterialSession;
use Connection\Session;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_session = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Session::getSession())):
    return $response->withJson(Session::getSession(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Session::getSession(), 200);
};
$mdl_material_session = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", MaterialSession::getMaterialSession($request->getParsedBody()))):
    return $response->withJson(MaterialSession::getMaterialSession($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(MaterialSession::getMaterialSession($request->getParsedBody()), 200);
};
$mdl_insert_session = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  /*if (key_exists("error", Session::insertSession($request->getParsedBody()))):
    return $response->withJson(Session::insertSession($request->getParsedBody()), 400);
  endif;*/
  $response = $next($request, $response);
  return $response->withJson(Session::insertSession($request->getParsedBody()), 200);
};