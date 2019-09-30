<?php


namespace Connection;


class Session extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getSession()
  {
    try {
      $c = self::Connect();
      $row = [];
      $query = $c->query("SELECT * FROM sessions;");
      if (!$query):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      foreach ($query as $rows):
        $row [] = $rows;
      endforeach;
      $data = array("ok" => true, "session" => $row);
      return $data;
    } catch (\PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  public static function insertSession($body)
  {
    try {
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO sessions (session, date_init, date_finish, material, id_planning, micro) 
                                        VALUES (:session, :date_init, :date_finish, :planning_id, :material, :micro);");
      $statement->bindParam(":session", $body["session"], \PDO::PARAM_STR);
      $statement->bindParam(":date_init", $body["dateInit"]);
      $statement->bindParam(":date_finish", $body["dateFinish"]);
      $statement->bindParam(":planning_id", $body["idPlanning"], \PDO::PARAM_INT);
      $statement->bindParam(":micro", $body["micro"], \PDO::PARAM_STR);
      foreach ($body["material"] as $value):
        $statement->bindParam(":material", $value, \PDO::PARAM_INT);
        $statement->execute();
      endforeach;
      if (!$statement):
        $data = array("ok" => false, "error" => "error en la consulta");
        $c = null;
        $statement = null;
        return $data;
      endif;
      $data = array("ok" => true, "message" => "insertado correctamente");
      $c = null;
      $statement = null;
      return $data;
    } catch (\PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}