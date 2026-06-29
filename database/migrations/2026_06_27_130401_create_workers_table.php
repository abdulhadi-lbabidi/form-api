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
    Schema::create('workers', function (Blueprint $table) {
      $table->id();

      $table->string('first_name');
      $table->string('last_name');
      $table->string('father_name');
      $table->string('mother_fullname');
      $table->string('phone_whatsapp');
      $table->integer('age');
      $table->string('city');
      $table->string('residential_area');
      $table->string('marital_status');

      $table->string('primary_profession');
      $table->text('other_professions')->nullable();
      $table->string('work_hours');
      $table->string('commitment_level');
      $table->decimal('expected_hourly_rate', 8, 2);

      $table->enum('currency', ['SYP', 'USD'])->default('SYP');

      $table->enum('payment_method', ['weekly', 'monthly']);



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
