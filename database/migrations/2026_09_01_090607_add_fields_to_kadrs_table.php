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
    Schema::table('kadrs', function (Blueprint $table) {
      $table->string('first_name')->nullable();
      $table->string('father_name')->nullable();
      $table->string('last_name')->nullable();
      $table->date('date_of_birth')->nullable();
      $table->string('residential_area')->nullable();
      $table->string('service_type')->nullable();
      $table->boolean('has_team')->default(false);
      $table->string('social_or_website_link')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('kadrs', function (Blueprint $table) {
      $table->dropColumn([
        'first_name',
        'father_name',
        'last_name',
        'date_of_birth',
        'residential_area',
        'service_type',
        'has_team',
        'social_or_website_link',
      ]);
    });
  }
};
