<?php

use App\Models\User;
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
    Schema::create('ratings', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Worker::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
      $table->tinyInteger('seriousness_level');
      $table->tinyInteger('skill_level');
      $table->enum('skill_matching', ['matched', 'partially_matched', 'not_matched'])->default('matched');
      $table->tinyInteger('communication_level');
      $table->string('red_flag')->nullable();
      $table->text('notes')->nullable();
      $table->boolean('is_verified')->default(false);
      $table->text('verification_notes')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ratings');
  }
};
