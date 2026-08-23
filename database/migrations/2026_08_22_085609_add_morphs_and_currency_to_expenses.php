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
    Schema::table('expenses', function (Blueprint $table) {
      $table->morphs('fundable');
      $table->text('description')->nullable();
      $table->foreignIdFor(Currency::class)
        ->constrained('currencies');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('expenses', function (Blueprint $table) {
      $table->dropMorphs('fundable');
      $table->dropColumn('description');
      $table->dropConstrainedForeignId('currency_id');
    });
  }
};
