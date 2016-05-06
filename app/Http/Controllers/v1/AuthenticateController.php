<?php

namespace FootStapp\Http\Controllers\v1;

use Hash;
use JWTAuth;
use Dingo\Api\Http\Request;
use FootStapp\Http\Controllers\Controller;
use FootStapp\Repositories\UserRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthenticateController extends Controller
{
  public function authenticate(Request $request, UserRepository $userRepository)
  {
    // grab credentials from the request
    $credentials = $request->only('email', 'password');

    // TODO Move user authentication code somewhere more appropriate

    $previousException = null;
    if ($credentials["email"] === null) {
      $previousException = new NotFoundHttpException("User not found.", null, 0x00C00101);
    }

    if ($credentials["password"] === null) {
      // TODO Test after code \FootStapp\Exceptions\Factory::collection()
      throw new NotFoundHttpException("User not found.", $previousException, 0x00C00102);
    } else if ($previousException !== null) {
      throw $previousException;
    }

    // Try to find user by email
    $user = $userRepository->findWhere(["email" => $credentials["email"]]);
    if (count($user) === 0) {
      // The user could not found by that email
      throw new NotFoundHttpException("User not found.", null, 0x00C00103);
    }

    /**
     * @var \FootStapp\Entities\User $user
     */
    $user = $user[0];

    if (!Hash::check($credentials["password"], $user->password)) {
      // Password mismatch
      throw new NotFoundHttpException("User not found.", null, 0x00C00104);
    }

    try {
      $token = JWTAuth::fromUser($user);
    } catch (JWTException $exception) {
      throw new \Exception("Couldn't create token", 0x00C00105);
    }

    return response()->json([
      "token" => $token,
      "user" => [
        "first_name" => $user->first_name,
        "middle_name" => $user->middle_name,
        "last_name" => $user->last_name,
        "email" => $user->email
      ]
    ]);
  }

  public function refresh(Request $request)
  {
    if ($request->token != null) {
      // First try to obtain token from request body...
      $token = $request->token;
    } else {
      // ...and then try to obtain from request header.
      $token = JWTAuth::getToken();
    }

    if (empty($token)) {
      // TODO Throw exception
    }

    $newToken = JWTAuth::refresh($token);

    return response()->json(["token" => $newToken]);
  }
}
