<?php

namespace App\Service;

use App\Models\ApplyJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ApplyJobService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::exact('worker_id'),
      AllowedFilter::exact('status'),
      AllowedFilter::exact('jobable_type'),
    ];

    $query = QueryBuilder::for(ApplyJob::class)
      ->with(['worker', 'jobable'])
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

  public function findOne(int $id): ApplyJob
  {
    return ApplyJob::with(['worker', 'jobable'])->findOrFail($id);
  }

  public function apply(array $data): ApplyJob
  {
    return DB::transaction(function () use ($data) {
      $workerId = $data['worker_id'];

      $exists = ApplyJob::where('worker_id', $workerId)
        ->where('jobable_type', $data['jobable_type'])
        ->where('jobable_id', $data['jobable_id'])
        ->exists();

      if ($exists) {
        throw new \Exception('لقد قمت بالتقديم على هذه الوظيفة مسبقاً.', 422);
      }

      $applyJob = ApplyJob::create([
        'worker_id'    => $workerId,
        'jobable_type' => $data['jobable_type'],
        'jobable_id'   => $data['jobable_id'],
        'status'       => 'pending',
        'notes'        => $data['notes'] ?? null,
      ]);

      return $applyJob->load(['worker', 'jobable']);
    });
  }
}