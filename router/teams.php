<?php
use Slim\Http\Request;
use Slim\Http\Response;
$app->get("/team", function (Request $request, Response $response){
   echo "team";
});