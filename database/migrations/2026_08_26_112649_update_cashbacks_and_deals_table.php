<?php

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
    Schema::table('cashbacks', function (Blueprint $table) {
      $table->dropColumn('is_favorite');
      $table->dropColumn('redirect_url');
      $table->dropColumn('number_of_clicks');
      $table->morphs('cashbackable');
      $table->string('owner_name')->nullable()->after('company_name');
      $table->string('phone_number')->nullable()->after('owner_name');
    });

    Schema::table('cashback_deals', function (Blueprint $table) {
      $table->boolean('is_favorite')->default(false)->after('status');
      $table->string('redirect_url')->nullable()->after('title');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('cashbacks', function (Blueprint $table) {
      $table->boolean('is_favorite')->default(false);
      $table->string('redirect_url')->nullable();
      $table->integer('number_of_clicks')->default(0);
      $table->dropMorphs('cashbackable');
      $table->dropColumn(['owner_name', 'phone_number']);
    });

    Schema::table('cashback_deals', function (Blueprint $table) {
      $table->dropColumn(['is_favorite', 'redirect_url']);
    });
  }
};
