<?php

use App\Models\Category;
use App\Models\Worker;
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
    Schema::create('categories', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description')->nullable();
      $table->timestamps();
    });

    Schema::create('category_workers', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Worker::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('categories');
    Schema::dropIfExists('category_workers');
  }
};
