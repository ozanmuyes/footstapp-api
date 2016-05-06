<?php

namespace FootStapp\Exceptions;

use Exception;
use InvalidArgumentException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Arrayable;

class ErrorObject implements Arrayable
{
  /**
   * A unique identifier for this particular occurrence of the problem.
   *
   * @var int $id
   */
  protected $id;

  /**
   * A links object containing the following members.
   *
   * @var \FootStapp\Exceptions\LinksObject|null $links
   */
  protected $links;

  /**
   * The HTTP status code applicable to this problem, expressed as a string value.
   *
   * @var string $status
   */
  protected $status = "500";

  /**
   * An application-specific error code, expressed as a string value.
   *
   * @var string|null $code
   */
  protected $code = null;

  /**
   * A short, human-readable summary of the problem that SHOULD NOT change from occurrence
   * to occurrence of the problem, except for purposes of localization.
   *
   * @var string|null $title
   */
  protected $title;

  /**
   * A human-readable explanation specific to this occurrence of the problem.
   *
   * @var string|null $detail
   */
  protected $detail;

  /**
   * An object containing references to the source of the error.
   *
   * @var array|null $source
   */
  protected $source;

  /**
   * A meta object containing non-standard meta-information about the error.
   *
   * @var array|null $meta
   */
  protected $meta;

  /**
   * ErrorObject constructor.
   *
   * @param Exception|string $first
   * @param string|null $second
   * @param array|string|int|null $third
   * @param int|null $fourth
   */
  public function __construct($first, $second = null, $third = null, $fourth = null)
  {
    if ($first instanceof Exception) {
      // $second argument is title
      // $third argument is source

      $this->createFromException($first);

      if ($second !== null) {
        $this->title = $second;
      }

      if ($third !== null) {
        $this->source = $third;
      }
    } else if (is_string($first)) {
      // $first argument is exception class
      // $second argument is detail
      // $third argument is title or code

      $this->status = self::getErrorStatusFromException($first);

      if ($third === null) {
        $this->title = Response::$statusTexts[intval($this->status)];
      } else if (is_string($third)) {
        // $third argument is title

        if ($fourth !== null) {
          $this->code = $fourth;
        }
        $this->title = $third;
      } else if (is_int($third)) {
        // $third argument is code

        $this->code = $third;
        $this->title = Response::$statusTexts[intval($this->status)];
      }

      $this->detail = $second;

      if (env("APP_DEBUG", false)) {
        $backtrace = debug_backtrace();
        $caller = array_shift($backtrace);

        // Check if caller is from FootStapp\Exception - if so go one step back
        if (strpos($caller['file'], "app/Exceptions/")) {
          $caller = array_shift($backtrace);
        }

        $this->meta = [
          "file" => $caller['file'],
          "line" => $caller['line']
        ];
      }
    }

    // TODO Add other construct methods here
  }

  protected function createFromException(Exception $exception)
  {
    $this->status = static::getErrorStatusFromException($exception);
    $this->code = $exception->getCode() > 0
      ? strval($exception->getCode())
      : intval("0x00E00" . $this->status, 16);
    $this->title = Response::$statusTexts[intval($this->status)];
    $this->detail = $exception->getMessage();

    // If APP_DEBUG is set add error meta information
    if (env("APP_DEBUG", false)) {
      $this->meta = [
        "file" => $exception->getFile(),
        "line" => $exception->getLine()
      ];
    }
  }

  /**
   * Get status.
   *
   * @return null|string
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Get the instance as an array.
   *
   * @return array
   */
  public function toArray()
  {
    if ($this->id !== null) {
      $errorObject["id"] = $this->id;
    }

    if ($this->links !== null) {
      $errorObject["links"] = $this->links;
    }

    $errorObject["status"] = $this->status;

    if ($this->code !== null) {
      if (env("APP_DEBUG", false)) {
        $errorObject["code"] = "0x" . str_pad(dechex(intval($this->code)), 8, "0", STR_PAD_LEFT);
      } else {
        $errorObject["code"] = $this->code;
      }
    }

    $errorObject["title"] = $this->title;

    if ($this->detail !== null) {
      $errorObject["detail"] = $this->detail;
    }

    if ($this->source !== null) {
      $errorObject["source"] = $this->source;
    }

    if ($this->meta !== null) {
      $errorObject["meta"] = $this->meta;
    }

    return $errorObject;
  }

  /**
   * Get error status depending on exception
   *
   * @param Exception|string $first
   *
   * @return string
   *
   * @throws InvalidArgumentException
   * @throws Exception
   */
  public static function getErrorStatusFromException($first)
  {
    if ($first instanceof Exception) {
      $className = get_class($first);
    } else if (is_string($first)) {
      $className = $first;
    } else {
      throw new InvalidArgumentException("Exception or string expected.", 0x00100101);
    }

    switch ($className) {
      case 'Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException': {
        return "403";
      }

      case 'Symfony\Component\HttpKernel\Exception\BadRequestHttpException': {
        return "400";
      }

      case 'Symfony\Component\HttpKernel\Exception\ConflictHttpException': {
        return "409";
      }

      case 'Symfony\Component\HttpKernel\Exception\GoneHttpException': {
        return "410";
      }

      case 'Symfony\Component\HttpKernel\Exception\HttpException': {
        return "500";
      }

      case 'Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException': {
        return "411";
      }

      case 'Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException': {
        return "405";
      }

      case 'Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException': {
        return "406";
      }

      case 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException': {
        return "404";
      }

      case 'Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException': {
        return "412";
      }

      case 'Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException': {
        return "428";
      }

      case 'Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException': {
        return "503";
      }

      case 'Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException': {
        return "429";
      }

      case 'Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException': {
        return "401";
      }

      case 'Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException': {
        return "415";
      }

      case 'Dingo\Api\Exception\DeleteResourceFailedException': {
        return "422";
      }

      case 'Dingo\Api\Exception\ResourceException': {
        return "422";
      }

      case 'Dingo\Api\Exception\StoreResourceFailedException': {
        return "422";
      }

      case 'Dingo\Api\Exception\UpdateResourceFailedException': {
        return "422";
      }

      case 'Illuminate\Database\Eloquent\ModelNotFoundException': {
        return "404";
      }

      case 'BadMethodCallException': {
        return "500";
      }

      case 'ReflectionException': {
        return "500";
      }

      case 'ErrorException': {
        return "500";
      }

      case 'Exception': {
        return "500";
      }

      default: {
        throw new Exception("Uncaught exception: {$className} .", 0x00100102);
      }
    }

    // TODO Add more exceptions here
  }
}
