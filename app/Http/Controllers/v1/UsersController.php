<?php

namespace FootStapp\Http\Controllers\v1;

use FootStapp\Http\Requests;
use Illuminate\Http\Request;
use FootStapp\Http\Controllers\Controller;
use FootStapp\Repositories\UserRepository;
use FootStapp\Transformers\UserTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UsersController extends Controller
{
  /**
   * @var \FootStapp\Repositories\UserRepository $repository
   */
  protected $repository;

  /**
   * UsersController constructor.
   * @param \FootStapp\Repositories\UserRepository $repository
   */
  public function __construct(UserRepository $repository)
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
    $user = $this->user();

//    if ($user == null) {
//      throw new UnauthorizedHttpException("Bearer", "You are not authorized to see all users.", null, 0x00C00301);
//    }

    if (!policy($user)->canSeeAll($user)) {
      throw new HttpException(403, "You are not authorized to see all users.", null, [], 0x00C00302);
    }

    $users = $this->repository->all();

    return $this->response->collection($users, new UserTransformer, ["key" => "users"]);
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
     // TODO Determine Request class name and set proper use stmt
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \FootStapp\Http\Response\Format\JsonApi
   */
  public function show($id)
  {
    //
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
