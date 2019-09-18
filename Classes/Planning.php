<?php


namespace Connection;


use PDO;
use PDOException;
use phpDocumentor\Reflection\Types\Null_;

class Planning extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getPlanning()
  {
    try {
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("SELECT * FROM planning;");
      $statement->execute();
      if (!$statement->rowCount() < 0):
        $data = array("ok" => false, "error" => "ERROR EN LA CONSULTA");
        return $data;
      endif;
      while ($rows = $statement->fetch()):
        $row [] = $rows;
      endwhile;
      $data = array("ok" => true, "planning" => $row);
      $c = null;
      $statement = null;
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function onlyPlanning($body)
  {
    try {
      $c = self::Connect();
      $id = $body["id"];
      $query = $c->query("SELECT * FROM planning WHERE id=$id;");
      if (!$query) {
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      }
      $row = $query->fetch();
      $data = array("ok" => true, "planning" => $row);
      $c = null;
      $query = null;
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }

  }

  public static function planningTeam($body)
  {
    try {
      $c = self::Connect();
      $id = $body["id"];
      $query = $c->query("select * from planning as p
                                  inner join teams as t
                                  on p.id = t.id_planning
                                  where t.id=$id");
      if (!$query):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      $row = $query->fetch();
      $data = array("ok" => true, "planning" => $row);
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function insertPlanning($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO planning (planning, data_init, data_finish) VALUES (:planning, :data_init, :data_finish);");
      $statement->bindParam(":planning", $body['planning'], PDO::PARAM_STR);
      $statement->bindParam(":data_init", $body["data_init"]);
      $statement->bindParam(":data_finish", $body["data_finish"]);
      $statement->execute();
      if ($statement->rowCount() == 0):
        $data = array("ok" => false, "error" => "error en consulta planning");
        $statement = null;
        $c = null;
        return $data;
      endif;
      $last_insert_id = $c->lastInsertId();
      $statement_team = $c->prepare("UPDATE teams SET id_planning=:last_insert_id WHERE id=:id;");
      $statement_team->bindParam(":last_insert_id", $last_insert_id, PDO::PARAM_INT);
      $statement_team->bindParam(":id", $body["id"], PDO::PARAM_INT);
      $statement_team->execute();
      if ($statement_team->rowCount() == 0):
        $data = array("ok" => false, "error" => "error en consulta update team");
        $statement = null;
        $c = null;
        return $data;
      endif;
      $data = array("ok" => true, "message" => "Planificació introduida");
      $c = null;
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}