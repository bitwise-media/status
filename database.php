<?php
class Database {
  private $database = '';
  
  function __construct (string $database = 'database') {
    $this->database = dirname(__FILE__) . '/data/' . $database;
  }
  
  public function read () {
    $json = '';

    if (file_exists($this->database . '.json')) {
      $json = file_get_contents($this->database . '.json');

      return json_decode($json, true);
    } else {
      return false;
    }
  }

  public function write (array $data) {
    $database = fopen($this->database . '.json', 'w');

    if (!$database) {
      return false;
    }

    $json = stripslashes(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $fwrite = fwrite($database, $json);
    fclose($database);

    return $fwrite;
  }
}
