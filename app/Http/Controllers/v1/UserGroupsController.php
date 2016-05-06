<?php

namespace FootStapp\Http\Controllers\v1;

use FootStapp\Http\Requests;
use Illuminate\Http\Request;
use FootStapp\Http\Controllers\Controller;
use FootStapp\Repositories\UserGroupRepository;
use FootStapp\Transformers\UserGroupTransformer;

class UserGroupsController extends Controller
{
  /**
   * @var \FootStapp\Repositories\UserGroupRepository $repository
   */
  protected $repository;

  /**
   * UsersController constructor.
   * @param \FootStapp\Repositories\UserGroupRepository $repository
   */
  public function __construct(UserGroupRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function index()
  {
    $userGroups = $this->repository->all();

    return $this->response->collection($userGroups, new UserGroupTransformer, ["key" => "user-groups"]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  Request  $request
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function show($id)
  {
    $userGroup = $this->repository->find($id);

    return $this->response->item($userGroup, new UserGroupTransformer, ["key" => "user-groups"]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function destroy($id)
  {
    //
  }
}
