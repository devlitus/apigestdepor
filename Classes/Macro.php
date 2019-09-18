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
      $statement = $c->prepare("SELECT macro, id_planning FROM macro group by macro, id_planning;");
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
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage(), "message" => $exception->errorInfo);
      return $data;
    }
  }
}