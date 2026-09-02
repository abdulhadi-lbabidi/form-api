<?php

use App\Models\Category;
use App\Models\Kadr;
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
    Schema::create('category_kadrs', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Kadr::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('category_kadrs');
  }
};
