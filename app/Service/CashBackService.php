<?php

namespace App\Service;

use App\Models\Cashback;

class CashBackService
{

  public function incrementClickAndGetUrl(int $id): ?string
  {
    $cashback = Cashback::find($id);

    if (!$cashback) {
      return null;
    }

    $cashback->increment('number_of_clicks');

    return $cashback->redirect_url;
  }
}
