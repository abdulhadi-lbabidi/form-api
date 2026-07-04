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
    Schema::create('companies', function (Blueprint $table) {
      $table->id();
      $table->string('company_name');
      $table->string('business_type');
      $table->string('code')
        ->nullable()
        ->unique();
      $table->string('city');
      $table->boolean('is_verified')->nullable();
      $table->text('problems_faced')->nullable();
      $table->string('form_referral_code')
        ->nullable();
      $table->string('work_location');
      $table->string('email')->unique();
      $table->string('phone_number')->unique();
      $table->string('owner_name');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('companies');
  }
};
