<?php

namespace Database\Seeders;

use App\Models\Time;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TimeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $startTime = Carbon::createFromTime(19, 0, 0);

    $endTime = Carbon::createFromTime(22, 45, 0);

    while ($startTime->lessThanOrEqualTo($endTime)) {

      $currentPeriodStart = $startTime->format('h:i A');
      $currentPeriodEnd   = $startTime->copy()->addMinutes(15)->format('h:i A');

      Time::create([
        'work_time' => "{$currentPeriodStart} - {$currentPeriodEnd}"
      ]);

      $startTime->addMinutes(15);
    }
  }
}
