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
      AllowedFilter::exact('phone'),

      AllowedFilter::exact('categories', 'categories.id'),


      AllowedFilter::callback('search', function ($query, $value) {
        $query->where(function ($q) use ($value) {
          $q->where('name', 'like', "%{$value}%")
            ->orWhere('first_name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%")
            ->orWhere('shop_address', 'like', "%{$value}%")
            ->orWhere('residential_area', 'like', "%{$value}%")
            ->orWhere('service_type', 'like', "%{$value}%")
            ->orWhere('social_or_website_link', 'like', "%{$value}%");
        });
      }),
    ];

    $query = QueryBuilder::for(Kadr::class)
      ->with(['marketingSources'])
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
  public function create(array $data, $imageFiles = null): Kadr
  {
    return DB::transaction(function () use ($data, $imageFiles) {

      // Sync marketing sources
      if (isset($data['marketing_source_ids'])) {
        $marketingSourceIds = $data['marketing_source_ids'];
        unset($data['marketing_source_ids']);
      }

      if (empty($data['password'])) {
        $data['password'] = Hash::make('12345678');
      } else {
        $data['password'] = Hash::make($data['password']);
      }

      $kadr = Kadr::create($data);

      if (isset($marketingSourceIds)) {
        $kadr->marketingSources()->sync($marketingSourceIds);
      }

      if ($imageFiles) {
        $this->attachMedia($kadr, $imageFiles);
      }
      return $kadr;
    });
  }

  public function findOne(int $id): Kadr
  {
    return Kadr::with(['marketingSources'])->findOrFail($id);
  }
  public function update(Kadr $kadr, array $data, $imageFile = null, array $deletedMediaIds = []): Kadr
  {
    return DB::transaction(function () use ($kadr, $data, $imageFile, $deletedMediaIds) {

      if (isset($data['marketing_source_ids'])) {
        $kadr->marketingSources()->sync($data['marketing_source_ids']);
        unset($data['marketing_source_ids']);
      }

      if (isset($data['password']) && !empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
      } else {
        unset($data['password']);
      }

      $kadr->update($data);

      if (!empty($deletedMediaIds)) {
        $mediaItems = $kadr->media()->whereIn('id', $deletedMediaIds)->get();

        foreach ($mediaItems as $media) {
          $media->delete();
        }
      }

      if ($imageFile) {
        $this->attachMedia($kadr, $imageFile);
      }

      return $kadr;
    });
  }

  public function delete(Kadr $kadr): bool
  {
    return DB::transaction(function () use ($kadr) {
      return $kadr->delete();
    });
  }


  private function attachMedia(Kadr $category, $imageFiles)
  {
    $files = is_array($imageFiles) ? $imageFiles : [$imageFiles];

    foreach ($files as $file) {
      if ($file) {
        $category->addMedia($file)->toMediaCollection('kadrs');
      }
    }
  }
}
