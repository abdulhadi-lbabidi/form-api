<?php

use App\Models\Company;
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
    Schema::create('company_feedback', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Company::class)->constrained('companies');
      $table->decimal('stars', 3, 2)->nullable();
      $table->text('reason')->nullable();
      $table->morphs('feedbackable');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('company_feedback');
  }
};
