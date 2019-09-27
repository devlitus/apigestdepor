<?php


namespace Connection;


class MaterialSession extends Session
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getMaterialSession($body)
  {
    try {
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("call sp_material_session_micro(:micro, :id)");
      $statement->bindParam(":micro", $body["micro"], \PDO::PARAM_STR);
      $statement->bindParam(":id", $body["id"], \PDO::PARAM_INT);
      $statement->execute();
      if (!$statement):
        $data = array("ok" => false, "error" => "Error en la consulta");
        return $data;
      endif;
      foreach ($statement as $value):
        $row [] = $value;
      endforeach;
      $data = array("ok" => true, "material" => $row);
      $c = null;
      $statement = null;
      return $data;
    } catch (\PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}