<?php

use App\Models\CompanyBranch;
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
    Schema::create('company_needs', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(CompanyBranch::class)
        ->constrained()
        ->cascadeOnDelete();
      $table->integer('required_workers_count');
      $table->string('required_profession');
      $table->enum('needed_at', ['today', 'this_week', 'this_month', 'not_specified_yet']);
      $table->enum('employment_type', ['full_time', 'part_time', 'daily_wage']);
      $table->decimal('offered_salary', 12, 2)->nullable();
      $table->enum('currency', ['USD', 'SYP'])->nullable();
      $table->text('additional_details')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('company_needs');
  }
};
