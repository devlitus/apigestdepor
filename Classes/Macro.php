<?php


namespace Connection;


use PDO;
use PDOException;

class Macro extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getMacro()
  {
    try {
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("SELECT * FROM macro;");
      $statement->execute();
      if ($statement->rowCount() === 0):
        $data = array("ok" => false, "error" => "Error en la consulta");
        return $data;
      endif;
      while ($rows = $statement->fetch()):
        $row [] = $rows;
      endwhile;
      $data = array("ok" => true, "macro" => $row);
      $statement = null;
      $c = null;
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function insertMacro($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO macro (macro, data_init, data_finish, id_planning) VALUES (:macro, :data_init, :data_finish, :id_planing);");
      $statement->bindParam(":macro", $body["macro"], PDO::PARAM_STR);
      $statement->bindParam(":data_init", $body["dataInit"]);
      $statement->bindParam(":data_finish", $body["dataFinish"]);
      $statement->bindParam(":id_planning", $body["idPlanning"], PDO::PARAM_INT);
      $statement->execute();
      if ($statement->rowCount() == 0):
        $data = array("ok" => false, "error" => "Error en la consulta");
        return $data;
      endif;
      $data = array("ok" => true, "message" => "Macro insertado");
      return $data;
    } catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}