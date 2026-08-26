<?php

namespace App\Service;

use App\Models\CashbackCounter;
use App\Models\CashbackDeal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CashBackDealService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::callback('search', function ($query, $value) {
        $query->where('title', 'like', "%{$value}%")
          ->orWhere('content', 'like', "%{$value}%");
      }),
      AllowedFilter::exact('status'),
      AllowedFilter::exact('cashback_id'),
      AllowedFilter::callback('category_id', function ($query, $value) {
        $ids = is_array($value) ? $value : explode(',', $value);

        $query->whereHas('cashback.categories', function ($q) use ($ids) {
          $q->whereIn('cashback_categories.id', $ids);
        });
      }),
    ];

    $query = QueryBuilder::for(CashbackDeal::class)
      ->with(['cashback.categories'])
      ->allowedFilters(...$filters)
      ->allowedSorts(
        'created_at',
        'id',
        'start_date',
        'end_date',
        'comosion'
      )
      ->defaultSort('-created_at');

    if ($paginate) {
      return $query->paginate(
        perPage: $perPage,
        page: $page,
        columns: $columns,
      );
    }

    return $query->get($columns);
  }

  public function findOne(CashbackDeal $cashbackDeal): CashbackDeal
  {
    return $cashbackDeal->load(['cashback']);
  }


  public function interact(CashbackDeal $cashbackDeal, string $type, int $id): array
  {
    if ($cashbackDeal->status !== 'active') {
      return [
        'success' => false,
        'message' => 'عذراً، هذا العرض غير نشط.',
        'status' => 404,
      ];
    }

    if (!class_exists($type) || !$type::where('id', $id)->exists()) {
      return [
        'success' => false,
        'message' => 'الجهة المرتبطة غير موجودة في النظام.',
        'status' => 422,
      ];
    }

    $counter = CashbackCounter::updateOrCreate(
      [
        'cashback_deal_id' => $cashbackDeal->id,
        'counterable_type' => $type,
        'counterable_id' => $id,
      ],
      []
    );

    return [
      'success' => true,
      'message' => 'تمت العملية بنجاح.',
      'data' => [
        'deal_id' => $cashbackDeal->id,
        'title' => $cashbackDeal->title,
        'redirect_url' => $cashbackDeal->redirect_url,
        'comosion' => $cashbackDeal->comosion,
        'interacted_at' => $counter->created_at,
      ],
      'status' => 200,
    ];
  }
}
