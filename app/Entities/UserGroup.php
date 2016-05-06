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
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property \Carbon\Carbon deleted_at
 * @property \FootStapp\Entities\User users
 * @property \FootStapp\Entities\Permission permissions
 */
class UserGroup extends Model implements Transformable
{
  use TransformableTrait, SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string $table
   */
  protected $table = 'user_groups';

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
   * Get users belongs to the user group.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function users()
  {
    return $this->belongsToMany(User::class)->withTimestamps();
  }

  /**
   * Get permissions belongs to the user group.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class)->withTimestamps();
  }
}
