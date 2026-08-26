<?php

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
    Schema::create('kadr_job_hostings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('kadr_id')->constrained('kadrs')->cascadeOnDelete();

      $table->string('title');
      $table->string('job_type');
      $table->integer('workers_count');
      $table->string('shift_period');
      $table->time('time_from')->nullable();
      $table->time('time_to')->nullable();
      $table->string('city');
      $table->string('district')->nullable();
      $table->string('experience_level');

      $table->decimal('salary_min', 10, 2)->nullable();
      $table->decimal('salary_max', 10, 2)->nullable();
      $table->string('currency');
      $table->string('salary_interval');

      $table->text('notes')->nullable();
      $table->string('status')->default('pending');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kadr_job_hostings');
  }
};
