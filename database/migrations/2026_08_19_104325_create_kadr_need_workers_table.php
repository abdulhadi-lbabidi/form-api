<?php

use App\Models\KadrNeed;
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
    Schema::create('kadr_need_workers', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(KadrNeed::class, 'kadr_need_id')
        ->constrained('kadr_needs')
        ->cascadeOnDelete();
      $table->foreignIdFor(Worker::class, 'worker_id')
        ->constrained('workers')
        ->cascadeOnDelete();
      $table->string('status')->default('pending');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kadr_need_workers');
  }
};
