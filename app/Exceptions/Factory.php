<?php

namespace FootStapp\Exceptions;

use Exception;
use ErrorException;
use Illuminate\Http\Response;

// TODO Maybe make use of FootStapp\Exceptions\Handler
// TODO Consider APP_DEBUG env property
// TODO Create and send a dump string for the error to be further investigated if APP_DEBUG set to false (e.g. put it in the meta object of error response)
class Factory
{
  /***
   * Sources either `pointer` to error or `parameter` name causes the error.
   * Itemized error's exception can NOT have previous exception.
   *
   * @param Exception|string $first
   * @param string|null $second
   * @param array|null $third
   * @param int|null $fourth
   *
   * @return Response
   *
   * @throws \ErrorException
   */
  public function item($first, $second = null, $third = null, $fourth = null)
  {
    /**
     * $this->item(AccessDeniedHttpException::class)
     * $this->item(AccessDeniedHttpException::class, "detail")
     * $this->item(AccessDeniedHttpException::class, "detail", "title")
     * $this->item(AccessDeniedHttpException::class, "detail", code)
     * $this->item(AccessDeniedHttpException::class, "detail", "title", code)
     */

    if ($first instanceof Exception && $first->getPrevious() !== null) {
      throw new ErrorException('Itemized error\'s exception can NOT have previous exception.');
    }

    $errorObject = new ErrorObject($first, $second, $third, $fourth);

    return new Response(["errors" => $errorObject], $errorObject->getStatus());
  }

  // TODO Write collection function
}
