<?php

namespace FootStapp\Exceptions;

use Exception;
use Dingo\Api\Http\Response;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that should not be reported.
   *
   * @var array
   */
  protected $dontReport = [
    HttpException::class,
    ModelNotFoundException::class,
  ];

  /**
   * @var \FootStapp\Exceptions\Factory $factory
   */
  protected $factory;

  /**
   * Controller constructor.
   *
   * @param \Psr\Log\LoggerInterface $log
   * @param \FootStapp\Exceptions\Factory $factory
   */
  public function __construct(LoggerInterface $log, Factory $factory)
  {
    parent::__construct($log);

    $this->factory = $factory;
  }

  /**
   * Report or log an exception.
   *
   * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
   *
   * @param  \Exception $e
   */
  public function report(Exception $e)
  {
    parent::report($e);
  }

  /**
   * Handle the exception and create corresponding error response.
   * This exceptions thrown by the application (Laravel) or any
   * vendor but not the API itself.
   *
   * @param \Exception $exception
   *
   * @return \Illuminate\Http\Response
   */
  public function handle(Exception $exception)
  {
    $this->report($exception);

    $previousException = $exception->getPrevious();

    if ($previousException === null) {
      return $this->factory->item($exception);
    } else {
      // TODO Write collection codes
    }

    // TODO Neglect Helper
    $errorsObject = Helper::createErrorsObjectFromException($exception);
    if (Helper::isIndividualErrorsStatusDiffers($errorsObject)) {
      $status = "422";
    } else {
      $status = strval($errorsObject[0]["status"]);
    }

    return new Response(["errors" => $errorsObject], $status);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Exception  $e
   * @return \Illuminate\Http\Response
   */
  public function render($request, Exception $e)
  {
    if ($e instanceof ModelNotFoundException) {
      $e = new NotFoundHttpException($e->getMessage(), $e);
    }

    return parent::render($request, $e);
  }
}
