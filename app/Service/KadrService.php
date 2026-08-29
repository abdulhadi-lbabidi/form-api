<?php

namespace App\Service;

use App\Models\Kadr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class KadrService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::exact('city'),
      AllowedFilter::partial('name'),
      AllowedFilter::exact('phone'),
    ];

    $query = QueryBuilder::for(Kadr::class)
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

  public function create(array $data): Kadr
  {
    return DB::transaction(function () use ($data) {
      $data['password'] = Hash::make($data['password']);

      return Kadr::create($data);
    });
  }

  public function update(Kadr $kadr, array $data): Kadr
  {
    return DB::transaction(function () use ($kadr, $data) {
      if (isset($data['password']) && !empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
      } else {
        unset($data['password']);
      }

      $kadr->update($data);

      return $kadr;
    });
  }

  public function delete(Kadr $kadr): bool
  {
    return DB::transaction(function () use ($kadr) {
      return $kadr->delete();
    });
  }
}
