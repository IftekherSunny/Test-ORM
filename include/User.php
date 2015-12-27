<?php

class User extends Model
{
  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * Hidden column name.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   * One user has many posts.
   *
   * @return object
   */
  public function posts()
  {
    return $this->hasMany('Post');
  }

  /**
   * Override name column value
   * when try to set name column value.
   *
   * @param string $value
   */
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = strtoupper($value);
  }

  /**
   * Override name column value
   * when try to get name column value.
   *
   * @return [type] [description]
   */
  public function getNameAttribute()
  {
    return $this->attributes['name'] . 'override';
  }
}
