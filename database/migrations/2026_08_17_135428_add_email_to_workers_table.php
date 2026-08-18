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
    Schema::table('workers', function (Blueprint $table) {
      $table->string('email')->nullable()->unique()->after('phone_whatsapp');
      $table->string('password')->nullable()->after('email');
      $table->rememberToken()->after('password');
    });

    Schema::table('companies', function (Blueprint $table) {
      $table->string('password')->nullable()->after('email');
      $table->rememberToken()->after('password');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('workers', function (Blueprint $table) {
      $table->dropColumn(['email', 'password', 'remember_token']);
    });

    Schema::table('companies', function (Blueprint $table) {
      $table->dropColumn(['password', 'remember_token']);
    });
  }
};
