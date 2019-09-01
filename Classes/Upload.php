<?php


namespace Connection;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class Upload
{
  static $directory;

  public function __construct()
  {
  }

  static function uploadFile(Request $req)
  {
    try{
      $app = new App();
      $filename = null;
      $container = $app->getContainer();
      $container['upload_directory'] = "uploads/users";
      self::$directory = $container->get('upload_directory');
      $uploadedFiles = $req->getUploadedFiles();
      if (isset($uploadedFiles['img'])) {
        $uploadedFile = $uploadedFiles['img'];
        $filename = self::moveUploadedFile(self::$directory, $uploadedFile);
      }
      return $filename;
    }catch (\Exception $exception){
      $data = array("ok" => false, "error" => $exception->getMessage());
      return $data;
    }
  }

  static function moveUploadedFile($directory, UploadedFile $uploadedFile)
  {
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(5));
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
  }
}