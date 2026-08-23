<?php

namespace App\Observers;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExpenseObserver
{

  public function creating(Expense $expense): void
  {
    $this->ensureSufficientBalance($expense);
  }


  public function created(Expense $expense): void
  {
    $this->subtractFromFund($expense, $expense->amount);
  }


  public function updating(Expense $expense): void
  {
    DB::transaction(function () use ($expense) {
      $originalFundType = $expense->getOriginal('fundable_type');
      $originalFundId = $expense->getOriginal('fundable_id');
      $originalCurrencyId = $expense->getOriginal('currency_id');
      $originalAmount = (float) $expense->getOriginal('amount');

      if (
        $originalFundType !== $expense->fundable_type ||
        $originalFundId !== $expense->fundable_id ||
        $originalCurrencyId !== $expense->currency_id
      ) {

        $this->addToSpecificFund($originalFundType, $originalFundId, $originalCurrencyId, $originalAmount);

        $this->ensureSufficientBalance($expense);

        $this->subtractFromFund($expense, $expense->amount);

        return;
      }

      $difference = $expense->amount - $originalAmount;

      if ($difference > 0) {
        $this->ensureSufficientBalance($expense, $difference);
        $this->subtractFromFund($expense, $difference);
      } elseif ($difference < 0) {
        $this->addToFund($expense, abs($difference));
      }
    });
  }


  public function deleted(Expense $expense): void
  {
    DB::transaction(function () use ($expense) {
      $this->addToFund($expense, $expense->amount);
    });
  }


  protected function ensureSufficientBalance(Expense $expense, ?float $requiredAmount = null): void
  {
    $amountToCheck = $requiredAmount ?? $expense->amount;

    if (!$expense->fundable_type || !$expense->fundable_id || !$expense->currency_id) {
      throw ValidationException::withMessages([
        'amount' => 'بيانات الصندوق أو العملة غير مكتملة.',
      ]);
    }

    $model = $expense->fundable_type;
    $fund = $model::find($expense->fundable_id);

    if (!$fund) {
      throw ValidationException::withMessages([
        'amount' => 'الصندوق المحدد غير موجود.',
      ]);
    }

    $pivot = $fund->currencies()->where('currency_id', $expense->currency_id)->first()?->pivot;

    if (!$pivot) {
      throw ValidationException::withMessages([
        'amount' => 'هذه العملة غير مربوطة بهذا الصندوق مسبقاً.',
      ]);
    }

    if ((float) $pivot->balance < $amountToCheck) {
      throw ValidationException::withMessages([
        'amount' => 'عذراً، الرصيد المتاح في الصندوق (' . number_format($pivot->balance, 2) . ') غير كافٍ لإتمام العملية.',
      ]);
    }
  }


  protected function subtractFromFund(Expense $expense, float $amount): void
  {
    DB::transaction(function () use ($expense, $amount) {
      $model = $expense->fundable_type;
      $fund = $model::find($expense->fundable_id);

      $pivot = $fund?->currencies()->where('currency_id', $expense->currency_id)->first()?->pivot;

      if ($pivot) {
        $fund->currencies()->updateExistingPivot($expense->currency_id, [
          'balance' => $pivot->balance - $amount
        ]);
      }
    });
  }


  protected function addToFund(Expense $expense, float $amount): void
  {
    $this->addToSpecificFund(
      $expense->fundable_type,
      $expense->fundable_id,
      $expense->currency_id,
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
}
