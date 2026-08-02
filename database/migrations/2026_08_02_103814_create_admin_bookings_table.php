<?php

use App\Models\AdminBooking;
use App\Models\Company;
use App\Models\User;
use App\Models\Worker;
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
    Schema::create('admin_bookings', function (Blueprint $table) {
      $table->id();


      $table->foreignIdFor(User::class)->constrained();
      $table->foreignIdFor(User::class, 'interviewer_id')->constrained('users');

      $table->date('booking_date');

      $table->time('time_from');
      $table->time('time_to');

      $table->text('notes')->nullable();
      $table->enum('status', ['pending', 'active', 'canceled', 'completed'])->default('pending');


      $table->timestamps();
    });

    Schema::create('admin_booking_relations', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(AdminBooking::class)->constrained('admin_bookings')->cascadeOnDelete();

      $table->foreignIdFor(Company::class)->nullable()->constrained('companies');
      $table->foreignIdFor(Worker::class)->nullable()->constrained('workers');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('admin_bookings');
  }
};
