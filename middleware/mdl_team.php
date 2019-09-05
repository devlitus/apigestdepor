<?php

use Connection\ConnectionDB;
use Connection\Team;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_team = function (Request $request, Response $response, callable $next){
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Team::getTeam())):
    return $response->withJson(Team::getTeam(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Team::getTeam(), 200);
};
$mdl_insert_team = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  $response = $next($request, $response);
  /*if (key_exists("error", Team::insert_team($request->getParsedBody()))):
    return $response->withJson(Team::insert_team($request->getParsedBody()), 400);
  endif;*/
  return $response->withJson(Team::insert_team($request->getParsedBody()), 201);
};
$mdl_update_team = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  $response = $next($request, $response);
  /*if (key_exists("error", Team::update_team($request->getParsedBody()))):
    return $response->withJson(Team::update_team($request->getParsedBody()), 400);
  endif;*/
  return $response->withJson(Team::update_team($request->getParsedBody()), 200);
};
$mdl_delete_team = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  $response = $next($request, $response);
  /*if (key_exists("error", Team::deleteTeam($request->getParsedBody()))):
    return $response->withJson(Team::deleteTeam($request->getParsedBody()), 400);
  endif;*/
  return $response->withJson(Team::deleteTeam($request->getParsedBody()), 200);
};