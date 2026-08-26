<?php

use App\Models\CashbackDeal;
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
    Schema::create('cashback_counters', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(CashbackDeal::class)
        ->constrained('cashback_deals');
      $table->morphs('counterable');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cashback_counters');
  }
};
