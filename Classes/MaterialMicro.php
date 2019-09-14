<?php


namespace Connection;


class MaterialMicro extends Macro
{
  public function __construct()
  {
    parent::__construct();
  }
  public static function getMaterialMicro()
  {
    try{
      $c = self::Connect();
      $row = [];
      $query = $c->query("SELECT * FROM material_micro;");
      if (!$query):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      foreach ($query as $rows):
        $row [] = $rows;
      endforeach;
      $data = array("ok" => true, "material" => $row);
      $c = null;
      $query = null;
      return $data;
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}