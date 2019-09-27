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
      $statement = $c->prepare("select id, username, lastname, email, telf, address, img, dni, birthday from users;");
      $statement->execute();
      while ($rows = $statement->fetch()):
        $row[] = $rows;
      endwhile;
      $data = array("ok" => true, "users" => $row);
      $c = null;
      $statement = null;
      return $data;
    } catch (PDOException $e) {
      $data = array("ok" => false, "error" => $e->getMessage());
      return $data;
    }
  }

  public static function login($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("select * from users where username=:username;");
      $statement->bindParam(":username", $body['username'], \PDO::PARAM_STR);
      $statement->execute();
      $user = $statement->fetch();
      $pass = $user['password'];
      if (password_verify($body['password'], $pass)):
        $data = array("ok" => true, "user" => $user);
        return $data;
      else:
        $data = array("ok" => false, "message" => "Usuari o contrasenya incorrecta");
        return $data;
      endif;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function detailUser($body)
  {
    try {
      $c = self::Connect();

      $statement = $c->prepare("SELECT username, lastname, email, password, telf, address, img, dni, birthday FROM users WHERE id=:id;");
      $statement->bindParam(":id", $body['id'], \PDO::PARAM_INT);
      $statement->execute();
      $user = $statement->fetch();
      $data = array("ok" => true, "user" => $user);
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function insertUser(Request $request, $body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO users (username, lastname, email, password, telf, address, dni, birthday)
                                            VALUES (:username, :lastname, :email, :password, :telf, :address, :dni, :birthday);");
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
      $birthday = $body['birthday'];
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

  public static function updateUser(Request $request, $body)
  {
    try {
      $c = self::Connect();
      $id = filter_var($body['id'], FILTER_VALIDATE_INT);
      $camps = "";
      $statement = $c->query("select * from users where id=$id;");
      $file = $statement->fetch();
      $file = $file['img'];
      if (key_exists("password", $body)):
        $pass = password_hash($body['password'], PASSWORD_DEFAULT, ['cost' => 10]);
        $new_pass = array("password" => $pass);
        $new_body = array_replace($body, $new_pass);
        foreach ($new_body as $item => $value):
          $camps .= $item . "='" . $value . "',";
        endforeach;
      else:
        foreach ($body as $item => $value):
          $camps .= $item . "='" . $value . "',";
        endforeach;
      endif;
      if (key_exists("img", $request->getUploadedFiles())):
        $new_filename = array("img" => Upload::uploadFile($request));
        $new_body = $new_filename;
        foreach ($new_body as $item => $value):
          $camps .= $item . "='" . $value . "',";
        endforeach;
        if ($new_filename !== $file): //TODO: warning solucionar
          unlink(Upload::$directory . '/' . $file);
        endif;
      endif;
      $camps = substr($camps, 0, -1);
      $camps = substr($camps, 7);
//      $consulta = "UPDATE users SET $camps WHERE id=$id;";
      $query = $c->query("UPDATE users SET $camps WHERE id=$id;");
      if (!$query):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      $data = array("ok" => true, "message" => "usuario actualizado");
      $query = null;
      $c = null;
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }

  }

  public static function deleteUser($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("DELETE FROM users WHERE id=:id;");
      $statement->bindParam(":id", $body['id'], \PDO::PARAM_INT);
      $statement->execute();
      $data = array("ok" => true, "message" => "Usuario eliminado");
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}
