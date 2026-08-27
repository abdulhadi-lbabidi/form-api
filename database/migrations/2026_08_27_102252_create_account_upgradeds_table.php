<?php

use App\Models\AccountUpgradeRequest;
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
    Schema::create('account_upgradeds', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(AccountUpgradeRequest::class)
        ->constrained('account_upgrade_requests');

      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->decimal('comosion', 8, 2)->nullable();
      $table->string('status')->default('active');



      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('account_upgradeds');
  }
};