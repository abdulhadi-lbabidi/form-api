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
    Schema::create('failed_registration_attempts', function (Blueprint $table) {
      $table->id();
      $table->string('target_type');
      $table->string('phone')->nullable();
      $table->string('ip_address')->nullable();
      $table->text('user_agent')->nullable();
      $table->json('payload')->nullable();
      $table->string('platform')->nullable();
      $table->string('browser')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('failed_registration_attempts');
  }
};
