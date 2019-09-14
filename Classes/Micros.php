<?php


namespace Connection;


class Micros extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getMicros()
  {
    try {
      $c = self::Connect();
      $row = [];
      $query = $c->query("SELECT * FROM micro;");
      if (!$query):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      foreach ($query as $rows):
        $row [] = $rows;
      endforeach;
      $data = array("ok" => true, "micro" => $row);
      $c = null;
      $query = null;
      return $data;
    } catch (\PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
  public static function insertMicro($body)
  {
    try{
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO micro (micro, date_init, date_finish, material, macro_id) 
                                            VALUES (:micro, :date_init, :date_finish, :material, :macro_id)");
      $statement->bindParam(":micro", $body["micro"], \PDO::PARAM_STR);
      $statement->bindParam(":date_init", $body["dateInit"]);
      $statement->bindParam(":date_finish", $body["dateFinish"]);
      $statement->bindParam(":macro_id", $body["idMacro"]);
      foreach ($body["material"] as $value):
        $statement->bindParam(":material", $value);
        $statement->execute();
      endforeach;
      $data = array("ok" => true, "message" => "correcto");
      $c = null;
      $statement = null;
      return $data;
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}