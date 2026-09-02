<?php

use App\Models\Category;
use App\Models\KadrJobHosting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('category_kadr_job_hostings', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(KadrJobHosting::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('category_kadr_job_hostings');
  }
};
