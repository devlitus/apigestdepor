<?php

use Connection\ConnectionDB;
use Connection\Micros;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_macro_micro = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Micros::materialMicro($request->getParsedBody()))):
    $response->withJson(Micros::materialMicro($request->getParsedBody()), 400);
  endif;
  $response = $next($request, $response);
  $response->withJson(Micros::materialMicro($request->getParsedBody()), 200);
};