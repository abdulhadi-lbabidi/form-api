<?php

namespace App\Observers;

use App\Models\Revenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RevenueObserver
{

  public function creating(Revenue $revenue): void
  {
    $this->ensureValidFund($revenue);
  }


  public function created(Revenue $revenue): void
  {
    $this->addToFund($revenue, $revenue->amount);
  }


  public function updating(Revenue $revenue): void
  {
    DB::transaction(function () use ($revenue) {
      $originalFundType = $revenue->getOriginal('fundable_type');
      $originalFundId = $revenue->getOriginal('fundable_id');
      $originalCurrencyId = $revenue->getOriginal('currency_id');
      $originalAmount = (float) $revenue->getOriginal('amount');

      if (
        $originalFundType !== $revenue->fundable_type ||
        $originalFundId !== $revenue->fundable_id ||
        $originalCurrencyId !== $revenue->currency_id
      ) {
        $this->subtractFromSpecificFund($originalFundType, $originalFundId, $originalCurrencyId, $originalAmount);

        $this->ensureValidFund($revenue);

        $this->addToFund($revenue, $revenue->amount);

        return;
      }

      $difference = $revenue->amount - $originalAmount;

      if ($difference > 0) {
        $this->addToFund($revenue, $difference);
      } elseif ($difference < 0) {
        $this->subtractFromFund($revenue, abs($difference));
      }
    });
  }


  public function deleted(Revenue $revenue): void
  {
    DB::transaction(function () use ($revenue) {
      $this->subtractFromFund($revenue, $revenue->amount);
    });
  }


  protected function ensureValidFund(Revenue $revenue): void
  {
    if (!$revenue->fundable_type || !$revenue->fundable_id || !$revenue->currency_id) {
      throw ValidationException::withMessages([
        'amount' => 'بيانات الصندوق أو العملة غير مكتملة.',
      ]);
    }

    $model = $revenue->fundable_type;
    $fund = $model::find($revenue->fundable_id);

    if (!$fund) {
      throw ValidationException::withMessages([
        'amount' => 'الصندوق المحدد غير موجود.',
      ]);
    }

    $pivot = $fund->currencies()->where('currency_id', $revenue->currency_id)->first()?->pivot;

    if (!$pivot) {
      throw ValidationException::withMessages([
        'amount' => 'هذه العملة غير مربوطة بهذا الصندوق مسبقاً.',
      ]);
    }
  }

  protected function addToFund(Revenue $revenue, float $amount): void
  {
    $this->addToSpecificFund(
      $revenue->fundable_type,
      $revenue->fundable_id,
      $revenue->currency_id,
      $amount
    );
  }


  protected function addToSpecificFund(string $fundType, int $fundId, int $currencyId, float $amount): void
  {
    DB::transaction(function () use ($fundType, $fundId, $currencyId, $amount) {
      $fund = $fundType::find($fundId);
      if (!$fund) return;

      $pivot = $fund->currencies()->where('currency_id', $currencyId)->first()?->pivot;
      if ($pivot) {
        $fund->currencies()->updateExistingPivot($currencyId, [
          'balance' => $pivot->balance + $amount
        ]);
      }
    });
  }


  protected function subtractFromFund(Revenue $revenue, float $amount): void
  {
    $this->subtractFromSpecificFund(
      $revenue->fundable_type,
      $revenue->fundable_id,
      $revenue->currency_id,
      $amount
    );
  }


  protected function subtractFromSpecificFund(string $fundType, int $fundId, int $currencyId, float $amount): void
  {
    DB::transaction(function () use ($fundType, $fundId, $currencyId, $amount) {
      $fund = $fundType::find($fundId);
      if (!$fund) return;

      $pivot = $fund->currencies()->where('currency_id', $currencyId)->first()?->pivot;
      if ($pivot) {
        $fund->currencies()->updateExistingPivot($currencyId, [
          'balance' => $pivot->balance - $amount
        ]);
      }
    });
  }
}
