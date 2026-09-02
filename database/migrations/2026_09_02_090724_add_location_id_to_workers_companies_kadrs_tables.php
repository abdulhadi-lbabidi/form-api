<?php

use App\Models\Location;
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
    Schema::table('workers', function (Blueprint $table) {
      $table->foreignIdFor(Location::class)
        ->nullable()
        ->constrained('locations');
    });

    Schema::table('companies', function (Blueprint $table) {
      $table->foreignIdFor(Location::class)
        ->nullable()
        ->constrained('locations');
    });

    Schema::table('kadrs', function (Blueprint $table) {
      $table->foreignIdFor(Location::class)
        ->nullable()
        ->constrained('locations');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('workers', function (Blueprint $table) {
      $table->dropForeign(['location_id']);
      $table->dropColumn('location_id');
    });

    Schema::table('companies', function (Blueprint $table) {
      $table->dropForeign(['location_id']);
      $table->dropColumn('location_id');
    });

    Schema::table('kadrs', function (Blueprint $table) {
      $table->dropForeign(['location_id']);
      $table->dropColumn('location_id');
    });
  }
};
