<?php


  namespace Connection;


  use PDO;
  use PDOException;

  class ConnectionDB
  {
    private static $dns = "mysql:host=localhost;dbname=gestdepor";
    private static $user = "root";
//    private static $pass = "carles";
    private static $pass = "Carles40;#";
    public function __construct()
    {
    }

    public static function Connect()
    {
      try {
        $pdo = new PDO(self::$dns, self::$user, self::$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
      } catch (PDOException $e) {
        $data = array("ok" => false, "error" => $e->getMessage());
        return $data;
      }

    }

  }