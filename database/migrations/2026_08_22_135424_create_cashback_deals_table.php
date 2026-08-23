<?php

use App\Models\Cashback;
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
    Schema::create('cashback_deals', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Cashback::class)->constrained();
      $table->date('start_date');
      $table->date('end_date');
      $table->decimal('comosion', 10, 2);
      $table->string('title');
      $table->string('status')->default('active');
      $table->text('content')->nullable();
      $table->string('images_content')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cashback_deals');
  }
};
