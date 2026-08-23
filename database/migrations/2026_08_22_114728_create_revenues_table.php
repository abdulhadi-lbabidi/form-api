<?php

use App\Models\Currency;
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
    Schema::create('revenues', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->decimal('amount', 12, 2);
      $table->morphs('fundable');
      $table->text('description')->nullable();
      $table->foreignIdFor(Currency::class)->constrained('currencies');
      $table->foreignId('created_by')->constrained('users');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('revenues');
  }
};
