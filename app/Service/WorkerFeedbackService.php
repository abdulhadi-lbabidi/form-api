<?php

namespace App\Service;

use App\Models\WorkerFeedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WorkerFeedbackService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::exact('worker_id'),
      AllowedFilter::exact('stars'),
      AllowedFilter::exact('feedbackable_type'),
      AllowedFilter::exact('feedbackable_id'),

      AllowedFilter::callback('search', function ($query, $value) {
        $query->where(function ($q) use ($value) {
          $q->where('reason', 'like', "%{$value}%");
        });
      }),
    ];

    $query = QueryBuilder::for(WorkerFeedback::class)
      ->with(['worker', 'feedbackable'])
      ->allowedFilters(...$filters)
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

  public function create(array $data): WorkerFeedback
  {
    return DB::transaction(function () use ($data) {
      return WorkerFeedback::create($data);
    });
  }

  public function findOne(int $id): WorkerFeedback
  {
    return WorkerFeedback::with(['worker', 'feedbackable'])->findOrFail($id);
  }

  public function update(WorkerFeedback $workerFeedback, array $data): WorkerFeedback
  {
    return DB::transaction(function () use ($workerFeedback, $data) {
      $workerFeedback->update($data);
      return $workerFeedback;
    });
  }

  public function delete(WorkerFeedback $workerFeedback): bool
  {
    return DB::transaction(function () use ($workerFeedback) {
      return $workerFeedback->delete();
    });
  }
}
