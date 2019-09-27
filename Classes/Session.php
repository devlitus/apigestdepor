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
      $row = [];
      $statement = $c->prepare("INSERT INTO sessions (session, date, planning_id, micro) 
                                        VALUES (:session, :date, :planning_id, :micro);");
      $statement->bindParam(":session", $body["session"], \PDO::PARAM_STR);
      $statement->bindParam(":date", $body["date"]);
      $statement->bindParam(":planning_id", $body["idPlanning"], \PDO::PARAM_INT);
      $statement->bindParam(":micro", $body["micro"], \PDO::PARAM_STR);
      $statement->execute();
      if (!$statement):
        $data = array("ok" => false, "error" => "error en la consulta");
        return $data;
      endif;
      foreach ($statement as $value):
        $row [] = $value;
      endforeach;
      $data = array("ok" => true, "session" => $row);
      return $data;

    } catch (\PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
}