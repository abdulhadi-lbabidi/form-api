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
    Schema::create('account_upgrade_requests', function (Blueprint $table) {
      $table->id();
      $table->morphs('morphable');

      $table->string('status')->default('pending');
      $table->text('notes')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('account_upgrade_requests');
  }
};
