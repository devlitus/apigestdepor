<?php

  use Slim\App;
  use Slim\Http\Request as Request;
  use Slim\Http\Response as Response;

  require_once "config/config.php";
  require_once "middleware/mdl_users.php";
  $app = new App($config);
  $app->get('/users', function (Request $request, Response $response) {
  })->add($mdl_get_users);
  $app->post("/insert_user", function (Request $request, Response $response) {
  })->add($mdl_insert_user);