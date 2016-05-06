<?php

namespace FootStapp\Exceptions;

use Exception;
use ErrorException;
use Illuminate\Http\Response;

/**
 * @property \FootStapp\Exceptions\Factory $error
 */
class Helper
{
  /**
   * Creates JSON API errors object from exception
   *
   * @param Exception $exception
   * @param array|null $errors
   *
   * @return array
   */
  public static function createErrorsObjectFromException(Exception $exception, $errors = null)
  {
    $status = static::getErrorStatusFromException($exception);
    $title = Response::$statusTexts[intval($status)];
    $code = $exception->getCode();
    $detail = $exception->getMessage();

    // Create this error object
    $error = [
      "status" => $status,
      "title" => $title,
      "detail" => $detail
    ];

    // Obtain error code from exception if set
    if ($code > 0) {
      $error["code"] = strval($code);
    }

    // If APP_DEBUG is set add error meta information
    if (env("APP_DEBUG", false)) {
      $error += [
        "meta" => [
          "file" => $exception->getFile(),
          "line" => $exception->getLine()
        ]
      ];
    }

    // Check if there is any previous exception. If so
    // process it as well.
    $previousException = $exception->getPrevious();

    // TODO test four options
    if ($errors === null) {
      if ($previousException === null) {
        $errors = [$error];
      } else {
        $errors = static::createErrorsObjectFromException($previousException, [$error]);
      }
    } else {
      if ($previousException === null) {
        $errors[] = $error;
      } else {
        $errors[] = static::createErrorsObjectFromException($previousException, [$error]);
      }
    }

    return $errors;
  }

  /**
   * IMPORTANT: Use ErrorObject instead
   * Get error status depending on exception
   *
   * @param Exception $exception
   *
   * @return string
   */
  public static function getErrorStatusFromException(Exception $exception)
  {
    if ($exception instanceof ErrorException) {
      return "500";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
      return "403";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException) {
      return "400";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\ConflictHttpException) {
      return "409";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\GoneHttpException) {
      return "410";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
      return "500";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException) {
      return "411";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
      return "405";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException) {
      return "406";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
      return "404";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException) {
      return "412";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException) {
      return "428";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException) {
      return "503";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException) {
      return "429";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
      return "401";
    } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException) {
      return "415";
    } else if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
      return "500";
    } else if ($exception instanceof \Dingo\Api\Exception\DeleteResourceFailedException) {
      return "422";
    } else if ($exception instanceof \Dingo\Api\Exception\ResourceException) {
      return "422";
    } else if ($exception instanceof \Dingo\Api\Exception\StoreResourceFailedException) {
      return "422";
    } else if ($exception instanceof \Dingo\Api\Exception\UpdateResourceFailedException) {
      return "422";
    } else {
      return "500";
    }

    // Add more exceptions here
  }

  /**
   * Checks if two or more individual error objects share same status (code).
   *
   * @param $errorsObject
   *
   * @return bool
   */
  public static function isIndividualErrorsStatusDiffers($errorsObject)
  {
    $errorsCount = count($errorsObject);

    if ($errorsCount > 1) {
      for ($i = 0; $i < $errorsCount; $i++) {
        if (!isset($errorsObject[$i]["status"])) {
          continue;
        }

        for ($j = $i + 1; $j < $errorsCount - ($i + 1); $j++) {
          if (!isset($errorsObject[$i - $j]["status"])) {
            continue;
          }

          if ($errorsObject[$i]["status"] === $errorsObject[$j]["status"]) {
            return true;
          }
        }
      }
    } else {
      return false;
    }
  }
}
