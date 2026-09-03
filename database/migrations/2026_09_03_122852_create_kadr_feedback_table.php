<?php

use App\Models\Kadr;
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
    Schema::create('kadr_feedback', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Kadr::class)->constrained('kadrs');
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
    Schema::dropIfExists('kadr_feedback');
  }
};
