<?php

namespace FootStapp\Transformers;

use League\Fractal\TransformerAbstract;

class TokenTransformer extends TransformerAbstract
{
  /**
   * Turn this item object into a generic array.
   *
   * @param array $token
   * @return array
   */
  public function transform($token)
  {
    return [
//      "id" => strval($user->id),
      "token" => $token
    ];
  }
}
