<?php

class Database
{
  /*
   * @var \PDO
   */
  protected $db;

  /**
   * Create a new database instance.
   */
  public function __construct()
  {
    try {
        $this->db = new \PDO("sqlite:" . __DIR__ . "/../database.sqlite");
    }
    catch(PDOException $e) {
        trigger_error("Database Connection Error ",E_USER_ERROR);
    }
  }
}
