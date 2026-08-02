<?php

use App\Models\User;
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
    Schema::table('companies', function (Blueprint $table) {
      $table->foreignIdFor(User::class)
        ->nullable()
        ->after('id')
        ->constrained('users');
    });

    Schema::table('workers', function (Blueprint $table) {
      $table->foreignIdFor(User::class)
        ->nullable()
        ->after('id')
        ->constrained('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('companies', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
      $table->dropColumn('user_id');
    });

    Schema::table('workers', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
      $table->dropColumn('user_id');
    });
  }
};
