<?php

namespace FootStapp\Repositories;

use FootStapp\Entities\User;
use Eos\Repository\Eloquent\BaseRepository;
use Eos\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent
 * @package namespace FootStapp\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
  /**
   * Specify Model class name
   *
   * @return string
   */
  public function model()
  {
    return User::class;
  }

  /**
   * Boot up the repository, pushing criteria
   */
  public function boot()
  {
    $this->pushCriteria(app(RequestCriteria::class));
  }
}
