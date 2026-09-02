<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'name',
  'description',
])]
class Category extends Model
{
  use HasFactory;

  public function workers(): BelongsToMany
  {
    return $this->belongsToMany(Worker::class, 'category_workers', 'category_id', 'worker_id');
  }

  public function companies(): BelongsToMany
  {
    return $this->belongsToMany(Company::class, 'category_companies', 'category_id', 'company_id');
  }


  public function kadrs(): BelongsToMany
  {
    return $this->belongsToMany(Kadr::class, 'category_kadrs', 'category_id', 'kadr_id');
  }

  public function companyJobHostings(): BelongsToMany
  {
    return $this->belongsToMany(
      CompanyJobHosting::class,
      'category_company_job_hostings',
      'category_id',
      'company_job_hosting_id'
    );
  }

  public function kadrJobHostings(): BelongsToMany
  {
    return $this->belongsToMany(
      KadrJobHosting::class,
      'category_kadr_job_hostings',
      'category_id',
      'kadr_job_hosting_id'
    );
  }
}
