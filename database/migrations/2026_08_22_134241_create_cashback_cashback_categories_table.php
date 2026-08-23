<?php

use App\Models\Cashback;
use App\Models\CashbackCategory;
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
    Schema::create('cashback_cashback_categories', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Cashback::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(CashbackCategory::class)->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cashback_cashback_categories');
  }
};
