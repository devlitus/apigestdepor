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
      $statement = $c->prepare("select u.id, u.username, u.lastname, u.email, u.telf, u.img, u.dni, u.birthday, t.team_name from users as u
                                          inner join teams as t
                                          on u.id_team = t.id;");
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
  public static function login($body)
  {
    $c = self::Connect();
    $statement = $c->prepare("select u.id, username, password, role from users as u
                  inner join roles r on u.id = r.id_user
                  where u.id=:id;");
    $statement->bindParam(":id", filter_var($body['id'], FILTER_VALIDATE_INT));
    $statement->execute();
    $use = $statement->fetch();
    $pass = $use['password'];
    if (password_verify($body['password'], $pass)):
      $data = array("ok" => true, "user" => $statement->fetch());
      return array($data);
      else:
      $data = array("ok" => false, "message" => "Usuari o contrasenya incorrecta");
      return $data;
    endif;
  }
  public static function insertUser(Request $request, $body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO users (username, lastname, email, password, telf, dni, birthday)
                                            VALUES (:username, :lastname, :email, :password, :telf, :dni, :birthday);");
      $statement->bindParam(":username", $username);
      $statement->bindParam(":lastname", $lastname);
      $statement->bindParam(":email", $email);
      $statement->bindParam(":password", $password);
      $statement->bindParam(":telf", $telf);
      $statement->bindParam(":dni", $dni);
      $statement->bindParam(":birthday", $birthday);
      $username = filter_var($body['username'], FILTER_SANITIZE_STRING);
      $lastname = filter_var($body['lastname'], FILTER_SANITIZE_STRING);
      $email = filter_var($body['email'], FILTER_VALIDATE_EMAIL);
      $password = password_hash($body['password'], PASSWORD_DEFAULT, array('cost' => 10));
      $telf = filter_var($body['telf'], FILTER_SANITIZE_STRING);
      $dni = filter_var($body['dni'], FILTER_SANITIZE_STRING);
      $birthday = $body['birthday'];
      $statement->execute();
      $last_insert_id = $c->lastInsertId();
      if (key_exists("role", $body)):
        $role = explode(",", $body['role']);
        $statement_role = $c->prepare("INSERT INTO roles (role, id_user) VALUES (:val, :id_user);");
        $statement_role->bindParam(":id_user", $last_insert_id, \PDO::PARAM_INT);
        $statement_role->bindParam(":val", $value, \PDO::PARAM_STR);
        foreach ($role as $value):
          $statement_role->execute();
        endforeach;
      endif;
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
      $statement = $c->prepare("SELECT * FROM users WHERE id=':id';");
      $statement->bindParam(":id", $id);
      $file = $statement->fetch();
      if (key_exists("password", $body)):
        $pass = password_hash($body['password'], PASSWORD_DEFAULT, ['cost' => 8]);
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
        if (!empty($file->img)):
          unlink(Upload::$directory . '/' . $file->img);
        endif;
      endif;
      $camps = substr($camps, 0, -1);
      $query = $c->query("UPDATE users SET $camps WHERE id='$id';");
      if (!$query->rowCount()):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      $data = array("ok" => true, "message" => "usuario actualizado");
      $query = null;
      $c = null;
      return $data;
    }catch (PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }

  }
}



/*[
  "id" => $row['id'] ,
  "username" => $row['username'],
  "role" => $row['role'],
]*/