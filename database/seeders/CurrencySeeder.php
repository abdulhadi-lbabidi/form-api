<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $currencies = [
      [
        'name' => 'دولار أمريكي',
        'symbol' => '$',
      ],
      [
        'name' => 'ليرة سورية',
        'symbol' => 'SYP',
      ],
      [
        'name' => 'ليرة تركية',
        'symbol' => '₺',
      ],
    ];

    foreach ($currencies as $currency) {
      Currency::updateOrCreate(
        $currency
      );
    }
  }
}
