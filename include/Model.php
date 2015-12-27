<?php

class Model extends Database
{
  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * Hidden column.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   * SQL query.
   *
   * @var string
   */
  protected $query;

  /**
   * SQL statement.
   *
   * @var string
   */
  protected $stmt;

  /**
   * Store all columns value.
   *
   * @var array
   */
  protected $attributes = [];

  /**
   * Get all data.
   *
   * @return array
   */
  public function all()
  {
    $this->query = "SELECT * FROM {$this->table}";

    $this->stmt = $this->db->query($this->query);

    $this->stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));

    return $this->get();
  }

  /**
   * Has many relationship.
   *
   * @param  string  $relationTableName ]
   * @return object
   */
  public function hasMany($relationTableName)
  {
    $instance = new $relationTableName;

    $tableName = strtolower(get_class($this));

    $this->query = "SELECT * FROM {$instance->table} WHERE {$tableName}_id = {$this->id}";

    $this->stmt = $this->db->query($this->query);

    $this->stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));

    return $this;
  }

  /**
   * Get all data.
   *
   * @return object
   */
  public function get()
  {
    return $this->stmt->fetchAll();
  }

  /**
   * Find data from database by id.
   *
   * @param  integer $id
   * @return object
   */
  public function find($id)
  {
    $this->id = $id;

    $this->query = "SELECT * FROM {$this->table} WHERE id = {$this->id}";

    $this->stmt = $this->db->query($this->query);

    $this->stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));

    return $this;
  }

  /**
   * Check a given string contains on the given string.
   *
   * @param string $haystack
   * @param string $needle
   *
   * @return bool
   */
  protected function contains($haystack, $needle)
  {
      if(strpos($haystack, $needle) === false) {
          return false;
      } else {
          return true;
      }
  }

  /**
   * Handle method as class property.
   *
   * @param  string $property
   * @return object
   */
  public function __get($property)
  {
    if(method_exists($this, $property)) {
      return $this->{$property}()->stmt->fetchAll();
    }

    $property = ucwords($property);

    $getAttribute = "get{$property}Attribute";

    return $this->{$getAttribute}();
  }

  /**
   * Dynamically set property value.
   *
   * @param string $columnName
   * @param mixed $value
   */
  public function __set($columnName, $value)
  {
    $columnName = ucwords($columnName);

    $setAttribute = "set{$columnName}Attribute";

    $this->{$setAttribute}($value);
  }

  /**
   * Dynamically handler column value.
   *
   * @param  string $method
   * @param  array $params
   */
  public function __call($method, $params)
  {
      // set column value
      if($this->contains($method, 'set') and $this->contains($method, 'Attribute')) {
          $this->attributes[strtolower($this->getFieldName($method, 'set'))] = $params[0];
      }

      // get column value
      if($this->contains($method, 'get') and $this->contains($method, 'Attribute')) {
          return $this->attributes[strtolower($this->getFieldName($method, 'get'))];
      }
  }

  /**
   * Get field name.
   *
   * @param  string $method
   * @param  string $type
   * @return string
   */
  protected function getFieldName($method, $type)
  {
    return str_replace('Attribute', '', str_replace($type, '', $method));
  }
}
