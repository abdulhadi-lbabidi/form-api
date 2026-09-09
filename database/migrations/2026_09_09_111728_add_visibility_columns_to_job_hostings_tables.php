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
    Schema::table('company_job_hostings', function (Blueprint $table) {
      $table->boolean('is_visible_time')->default(false)->after('status');
      $table->boolean('is_visible_salary')->default(false)->after('is_visible_time');
    });

    Schema::table('kadr_job_hostings', function (Blueprint $table) {
      $table->boolean('is_visible_time')->default(false)->after('status');
      $table->boolean('is_visible_salary')->default(false)->after('is_visible_time');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('company_job_hostings', function (Blueprint $table) {
      $table->dropColumn(['is_visible_time', 'is_visible_salary']);
    });

    Schema::table('kadr_job_hostings', function (Blueprint $table) {
      $table->dropColumn(['is_visible_time', 'is_visible_salary']);
    });
  }
};
