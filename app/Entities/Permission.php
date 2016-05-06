<?php

namespace FootStapp\Entities;

use Illuminate\Database\Eloquent\Model;
use Eos\Repository\Contracts\Transformable;
use Eos\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string name
 * @property string title
 * @property string
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property \Carbon\Carbon deleted_at
 * @property array userGroups
 */
class Permission extends Model implements Transformable
{
  use TransformableTrait, SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string $table
   */
  protected $table = 'permissions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array $fillable
   */
  protected $fillable = [
    'name',
    'title'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array $hidden
   */
  protected $hidden = [];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * Get user groups has the permission.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function userGroups()
  {
    return $this->belongsToMany(UserGroup::class)->withTimestamps();
  }
}
