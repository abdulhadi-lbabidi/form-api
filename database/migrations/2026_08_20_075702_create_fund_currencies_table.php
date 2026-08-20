<?php

use App\Models\Currency;
use App\Models\Fund;
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
    Schema::create('fund_currencies', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Fund::class)->constrained('funds');
      $table->foreignIdFor(Currency::class)->constrained('currencies');
      $table->decimal('balance', 12, 2)->default(0);
      $table->decimal('min_withdrawal_threshold', 12, 2)->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('fund_currencies');
  }
};
