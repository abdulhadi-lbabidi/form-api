<?php

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
    Schema::create('apply_jobs', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Worker::class)->constrained()->cascadeOnDelete();

      $table->morphs('jobable');

      $table->string('status')->default('pending');
      $table->text('notes')->nullable();


      $table->unique(['worker_id', 'jobable_type', 'jobable_id']);


      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('apply_jobs');
  }
};
