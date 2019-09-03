<?php


namespace Connection;


use PDO;
use PDOException;

class Team extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getTeam()
  {
    try {
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("SELECT * FROM teams;");
      $statement->execute();
      while ($rows = $statement->fetch()):
        $row [] = $rows;
      endwhile;
      $data = array("ok" => true, "teams" => $row);
      $c = null;
      $statement = null;
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function insert_team($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO teams (team) VALUES (:name);");
      $statement->bindParam(":name", $name);
      $name = filter_var($body['name'], FILTER_SANITIZE_STRING);
      $statement->execute();
      if (!$statement):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      else:
        $data = array("ok" => true, "message" => "Equipo insertado");
        return $data;
      endif;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function update_team($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("UPDATE teams SET team=:name WHERE id=:id;");
      $statement->bindParam(":id", $body["id"]);
      $statement->bindParam(":name", $body["name"], PDO::PARAM_STR);
      $statement->execute();
      if (!$statement):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      else:
        $data = array("ok" => true, "message" => "Equipo actualizado");
        $c = null;
        $statement = null;
        return $data;
      endif;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function deleteTeam($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("DELETE FROM teams WHERE id=:id;");
      $statement->bindParam(":id", $body["id"]);
      $statement->execute();
      if (!$statement):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      else:
        $data = array("ok" => true, "message" => "Equipo eliminado");
        $c = null;
        $statement = null;
        return $data;
      endif;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}