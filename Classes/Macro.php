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
      $statement = $c->prepare("SELECT macro, id_planning FROM macro GROUP BY id_planning, macro;");
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
  public static function getMacroPlanning($body)
  {
    try{
      $c = self::Connect();
      $id_planning = $body['id'];
      $row = [];
      $query = $c->query("SELECT material, id_planning FROM macro WHERE id_planning=$id_planning;");
      if (!$query):
        $data = array("ok" => false, "error" => "Error en la consulta");
        return $data;
      endif;
      foreach ($query as $rows):
        $row [] = $rows;
      endforeach;
      $data = array("ok" => true, "macro" => $row, "id_planning" =>$id_planning);
      $statement = null;
      $c = null;
      return $data;
    }catch (PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
  public static function insertMacro($body)
  {
    try{
      $c = self::connect();
      $statement = $c->prepare("INSERT INTO macro (macro, date_init, date_finish, material, id_planning) 
                                              VALUES (:macro, :date_init, :date_finish, :material, :id_planning);");
      $statement->bindParam(":macro", $body["macro"], PDO::PARAM_STR);
      $statement->bindParam(":date_init", $body["dateInit"]);
      $statement->bindParam(":date_finish", $body["dateFinish"]);
      $statement->bindParam(":id_planning", $body["idPlanning"]);
      foreach ($body["material"] as $value){
        $statement->bindParam(":material", $value);
        $statement->execute();
      }
      $data = array("ok" => true, "message" => "correcto");
      return $data;
    }catch (PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage(), "message" => $exception->errorInfo);
      return $data;
    }
  }
}