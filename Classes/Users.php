<?php

namespace Connection;


use PDOException;
use Slim\Http\Request;

class Users extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getUsers()
  {
    try {
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("");
      $statement->execute();
      while ($rows = $statement->fetch()):
        $row[] = $rows;
      endwhile;
      $data = array("ok" => true, "users" => $row);
      return $data;
    } catch (PDOException $e) {
      $data = array("ok" => false, "error" => $e->getMessage());
      return $data;
    }

  }

  public static function insertUser(Request $request, $body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO users (username, lastname, email, password, telf, address, dni, birthday)
                                            VALUES (:username, :lastname, :email, :password, :telf, :addres, :dni, :birthday);");
      $statement->bindParam(":username", $username);
      $statement->bindParam(":lastname", $lastname);
      $statement->bindParam(":email", $email);
      $statement->bindParam(":password", $password);
      $statement->bindParam(":telf", $telf);
      $statement->bindParam(":address", $address);
      $statement->bindParam(":dni", $dni);
      $statement->bindParam(":birthday", $birthday);
      $username = filter_var($body['username'], FILTER_SANITIZE_STRING);
      $lastname = filter_var($body['lastname'], FILTER_SANITIZE_STRING);
      $email = filter_var($body['email'], FILTER_VALIDATE_EMAIL);
      $password = password_hash($body['password'], PASSWORD_DEFAULT, array('cost' => 10));
      $telf = filter_var($body['telf'], FILTER_SANITIZE_STRING);
      $address = filter_var($body['address'], FILTER_SANITIZE_STRING);
      $dni = filter_var($body['dni'], FILTER_SANITIZE_STRING);
      $statement->execute();
      $last_insert_id = $c->lastInsertId();
      if (key_exists("img", $request->getUploadedFiles())):
        $statement_img = $c->prepare("UPDATE users SET img=:img WHERE id=$last_insert_id;");
        $statement_img->bindValue(":img", Upload::uploadFile($request));
        $statement_img->execute();
      endif;
      $data = array("ok" => true, "message" => "Usuario introducido correctamente");
      return $data;
    } catch (PDOException $e) {
      $data = array("ok" => false, "error" => $e->getMessage());
      return $data;
    }
  }
}