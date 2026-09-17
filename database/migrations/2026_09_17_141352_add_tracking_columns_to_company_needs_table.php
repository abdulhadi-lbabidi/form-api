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
    Schema::table('company_needs', function (Blueprint $table) {
      $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
      $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('company_needs', function (Blueprint $table) {
      $table->dropForeign(['added_by']);
      $table->dropForeign(['updated_by']);

      $table->dropColumn(['added_by', 'updated_by']);
    });
  }
};
