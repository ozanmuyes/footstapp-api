<?php

namespace FootStapp\Repositories;

use FootStapp\Entities\UserGroup;
use Eos\Repository\Eloquent\BaseRepository;
use Eos\Repository\Criteria\RequestCriteria;

/**
 * Class UserGroupRepositoryEloquent
 * @package namespace FootStapp\Repositories;
 */
class UserGroupRepositoryEloquent extends BaseRepository implements UserGroupRepository
{
  /**
   * Specify Model class name
   *
   * @return string
   */
  public function model()
  {
    return UserGroup::class;
  }

  /**
   * Boot up the repository, pushing criteria
   */
  public function boot()
  {
    $this->pushCriteria(app(RequestCriteria::class));
  }
}
