<?php


namespace Connection;


class Teams extends ConnectionDB
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function getTeams()
  {
    try {
      $c = self::Connect();
      $row = [];
      $statement = $c->prepare("SELECT * FROM teams;");
      $statement->execute();
      while ($rows = $statement->fetch()):
        $row [] = $rows;
      endwhile;
      $data = array("ok" => true, "teams" => $row);
      return $data;
    } catch (\PDOException $exception) {
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
  public static function insertTeam($body)
  {
    try{
      $c = self::Connect();
      $statement = $c->prepare("INSERT INTO teams (team) VALUES (:team);");
      $statement->bindParam(":team", $body["team"], \PDO::PARAM_STR);
      $statement->execute();
      $data = array("ok" => true, "message" => "Equip creat");
      return $body["team"];
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
  public static function updateTeam($body)
  {
    try{
      $c = self::Connect();
      $statement = $c->prepare("UPDATE teams SET team=:team WHERE id=:id;");
      $statement->bindParam(":team", $body['team'], \PDO::PARAM_STR);
      $statement->bindParam(":id", $body['id'], \PDO::PARAM_INT);
      $statement->execute();
      $data = array("ok" => true, "message" => "Equip Actualitzat");
      return $data;
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }
  public static function deleteTeam($body)
  {
    try{
      $c = self::Connect();
      $statement = $c->prepare("DELETE FROM teams WHERE id=:id;");
      $statement->bindParam(":id", $body['id'], \PDO::PARAM_INT);
      $statement->execute();
      $data = array("ok" => true, "message" => "Equip Eliminat", $body['id']);
      return $data;
    }catch (\PDOException $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

}