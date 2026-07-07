<?php

use App\Models\MarketingSource;
use App\Models\ReferralCode;
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
    Schema::create('workers', function (Blueprint $table) {
      $table->id();
      $table->string('code')
        ->nullable()
        ->unique();
      $table->string('form_referral_code')
        ->nullable();
      $table->string('first_name');
      $table->string('last_name');
      $table->string('father_name');
      $table->string('full_name')->nullable();
      $table->string('mother_fullname')->nullable();
      $table->string('phone_whatsapp')->unique();
      $table->date('age');
      $table->string('city');
      $table->string('residential_area');
      $table->string('marital_status');
      $table->boolean('is_verified')->nullable();
      $table->string('primary_profession');
      $table->text('other_professions')->nullable();
      $table->string('work_hours');
      $table->string('commitment_level');
      $table->string('working_status');
      $table->decimal('expected_hourly_rate_usd', 8, 2);
      $table->decimal('expected_hourly_rate_syp', 8, 2);
      $table->enum('payment_method', ['weekly', 'monthly','daily']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('workers');
  }
};
