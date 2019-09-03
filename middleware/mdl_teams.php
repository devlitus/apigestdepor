<?php

use Connection\ConnectionDB;
use Connection\Teams;
use Slim\Http\Request;
use Slim\Http\Response;

$mdl_get_teams = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  if (key_exists("error", Teams::getTeams())):
    return $response->withJson(Teams::getTeams(), 400);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Teams::getTeams(), 200);
};
$mdl_insert_team = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Teams::insertTeam($request->getParsedBody()), 201);
};
$mdl_update_team = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Teams::updateTeam($request->getParsedBody()), 201);
};
$mdl_delete_team = function (Request $request, Response $response, callable $next) {
  if (key_exists("error", ConnectionDB::Connect())):
    return $response->withJson(ConnectionDB::Connect(), 500);
  endif;
  $response = $next($request, $response);
  return $response->withJson(Teams::deleteTeam($request->getParsedBody()), 200);
};