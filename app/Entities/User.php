<?php

namespace FootStapp\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Eos\Repository\Contracts\Transformable;
use Eos\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property integer id
 * @property string first_name
 * @property string middle_name
 * @property string last_name
 * @property string email
 * @property string password
 * @property string remember_token
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property \Carbon\Carbon deleted_at
 * @property \FootStapp\Entities\UserGroup userGroups
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, Transformable
{
  use Authenticatable, Authorizable, CanResetPassword, TransformableTrait, SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string $table
   */
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array $fillable
   */
  protected $fillable = [
    'first_name',
    'middle_name',
    'last_name',
    'email',
    'password'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array $hidden
   */
  protected $hidden = [
    'password',
    'remember_token'
  ];

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
   * Get user group(s) that the user belongs to.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function userGroups()
  {
    return $this->belongsToMany(UserGroup::class)->withTimestamps();
  }
}
