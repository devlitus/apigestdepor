<?php


namespace Connection;


class MaterialMicro extends Macro
{
  public function __construct()
  {
    parent::__construct();
  }
  public static function getMaterialMicro($body)
  {
    try{
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("call sp_material_micro_macro(:macro, :id);");
      $statement->bindParam(":macro", $body["macro"], \PDO::PARAM_STR);
      $statement->bindParam(":id", $body["id"], \PDO::PARAM_INT);
      $statement->execute();
      if (!$statement):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      foreach ($statement as $value):
        $row [] =  $value;
      endforeach;
      $data = array("ok" => true, "material" => $row);
      $c = null;
      $statement = null;
      return $data;
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}