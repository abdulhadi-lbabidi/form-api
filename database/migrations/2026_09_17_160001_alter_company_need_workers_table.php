<?php

use App\Models\Delegate;
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
    Schema::table('company_need_workers', function (Blueprint $table) {
      $table->foreignIdFor(Delegate::class)
        ->nullable()
        ->constrained('delegates')
        ->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('company_need_workers', function (Blueprint $table) {
      $table->dropForeign(['delegate_id']);
      $table->dropColumn(['delegate_id']);
    });
  }
};
