<?php

namespace FootStapp\Http\Response\Format;

use Dingo\Api\Http\Response\Format\Json;

class JsonApi extends Json
{
  /**
   * Get the response content type.
   *
   * @return string
   */
  public function getContentType()
  {
    return 'application/vnd.api+json';
  }
}
