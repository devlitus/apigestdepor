<?php


namespace Connection;

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
  public static function materialMacro(){
    try{
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("SELECT * FROM material_macro;");
      $statement->execute();
      if ($statement->rowCount() === 0):
        $data = array("ok" => false, "error" => "Error en la consulta");
        return $data;
      endif;
      while ($rows = $statement->fetch()):
        $row [] = $rows;
      endwhile;
      $data = array("ok" => true, "material" => $row);
      $statement = null;
      $c = null;
      return $data;
    }catch (PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
  public static function insertMacro($body)
  {
    try {
      $c = self::Connect();
      $macro = filter_var($body['macro'], FILTER_SANITIZE_STRING);
      $date_init = $body['dataInit'];
      $date_finish  = $body["dataFinish"];
      $id_planning = $body["idPlanning"];
      $material = $body["material"];
      $statement = $c->prepare("INSERT INTO macro (macro, date_init, date_finish, material, id_planning) VALUES (:macro, :date_init, :date_finish, :material, :id_planing);");
      $statement->bindParam(":macro", $macro);
      $statement->bindParam(":date_init", $date_init);
      $statement->bindParam(":date_finish", $date_finish);
      $statement->bindParam(":id_planning", $id_planning);
      $statement->bindParam(":material", $value);
      foreach ($material as $value):
        $statement->execute();
      endforeach;
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