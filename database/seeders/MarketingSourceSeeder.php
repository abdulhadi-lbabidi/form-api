<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarketingSourceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $sources = [
      ['en' => 'Facebook', 'ar' => 'فيسبوك'],
      ['en' => 'Instagram', 'ar' => 'إنستغرام'],
      ['en' => 'LinkedIn', 'ar' => 'لينكد إن'],
      ['en' => 'TikTok', 'ar' => 'تيك توك'],
      ['en' => 'Google Search', 'ar' => 'بحث جوجل'],
      ['en' => 'Friend / Recommendation', 'ar' => 'صديق / توصية'],
      ['en' => 'WhatsApp Groups', 'ar' => 'مجموعات واتساب'],
      ['en' => 'Street Ads / Brochures', 'ar' => 'الإعلانات الطرقية أو (البروشورات)'],
      ['en' => 'Other', 'ar' => 'أخرى'],
    ];

    foreach ($sources as $source) {
      DB::table('marketing_sources')->insertOrIgnore([
        'name' => json_encode(['en' => $source['en'], 'ar' => $source['ar']], JSON_UNESCAPED_UNICODE),
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
