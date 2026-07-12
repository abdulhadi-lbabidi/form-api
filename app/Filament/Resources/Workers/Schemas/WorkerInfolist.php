<?php

namespace App\Filament\Resources\Workers\Schemas;

use App\Models\ReferralCode;
use App\Models\Company;
use App\Models\Worker;
use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry; // تم استيراد هذا المكون
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Illuminate\Support\Carbon;
use ZipArchive;

class WorkerInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('الملف الشخصي للعامل')
          ->icon('heroicon-o-user-circle')
          ->description('البيانات الشخصية الأساسية ومعلومات العائلة.')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('first_name')
                ->label('الاسم الأول')
                ->placeholder(' لا يوجد')

                ->weight('bold'),
              TextEntry::make('last_name')
                ->label('العائلة')
                ->placeholder(' لا يوجد')

                ->weight('bold'),
              TextEntry::make('father_name')
                ->placeholder(' لا يوجد')

                ->label('اسم الأب'),
              TextEntry::make('mother_name')
                ->placeholder(' لا يوجد')

                ->label('اسم الأم الكامل'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('age')
                ->label('تاريخ الميلاد (العمر)')
                ->icon('heroicon-m-calendar-days')
                ->formatStateUsing(function ($state) {
                  if (!$state) return '-';
                  $date = Carbon::parse($state);
                  return $date->format('Y-m-d') . ' (' . $date->age . ' سنة)';
                })
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family:cairo;']),

              TextEntry::make('marital_status')
                ->label('الحالة الاجتماعية')
                ->color(fn($state) => match ($state) {
                  'single' => 'info',
                  'married' => 'success',
                  default => 'gray'
                })
                ->formatStateUsing(fn($state) => match ($state) {
                  'single' => 'عازب',
                  'married' => 'متزوج',
                  'other' => 'غير ذلك',
                  default => $state
                }),

              TextEntry::make('phone_whatsapp')
                ->label('رقم الهاتف / واتساب')
                ->icon('heroicon-m-phone')
                ->placeholder(' لا يوجد')

                ->color('success')
                ->url(fn($record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->phone_whatsapp), shouldOpenInNewTab: true)
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: bold;']),
            ]),
          ])->columnSpanFull(),

        Section::make('السكن وطبيعة العمل')
          ->icon('heroicon-o-briefcase')
          ->description('تفاصيل مكان الإقامة، والمهن المتاحة، والبيانات المالية.')
          ->columns(3)
          ->schema([
            TextEntry::make('city')
              ->label('المدينة / المحافظة')
              ->placeholder(' لا يوجد')

              ->icon('heroicon-m-map-pin')
              ->color('primary'),

            TextEntry::make('residential_area')
              ->label('المنطقة / السكن')
              ->placeholder(' لا يوجد')

              ->icon('heroicon-m-map'),

            TextEntry::make('primary_profession')
              ->label('المهنة الأساسية')
              ->placeholder(' لا يوجد')
              ->icon('heroicon-m-briefcase')
              ->weight('bold'),

            TextEntry::make('work_hours')
              ->label('ساعات العمل المتاحة')
              ->icon('heroicon-m-clock')
              ->formatStateUsing(fn($state) => match ($state) {
                'morning'  => 'صباحي',
                'evening'  => 'مسائي',
                'night'    => 'ليلي',
                'flexible' => 'مرن',
                default    => $state,
              }),

            TextEntry::make('commitment_level')
              ->label('مستوى الالتزام')
              ->color(fn($state) => match ($state) {
                'full_time' => 'success',
                'part_time' => 'warning',
                'hourly'    => 'info',
                default     => 'gray',
              })
              ->formatStateUsing(fn($state) => match ($state) {
                'full_time' => 'دوام كامل',
                'part_time' => 'دوام جزئي',
                'hourly'    => 'بالساعة',
                default     => $state,
              }),

            TextEntry::make('working_status')
              ->label('حالة العمل الحالية')
              ->color(fn($state) => match ($state) {
                'working_now' => 'success',
                'not_working' => 'danger',
                'part_time'   => 'warning',
                'full_time'   => 'info',
                default       => 'gray',
              })
              ->formatStateUsing(fn($state) => match ($state) {
                'working_now' => 'تعمل حالياً',
                'not_working' => 'لا أعمل حالياً',
                'part_time'   => 'نعم بدوام جزئي',
                'full_time'   => 'نعم بدوام كامل',
                default       => $state,
              }),

            TextEntry::make('marketingSources.name')
              ->label('مصادر التعرف علينا')
              ->state(fn($record) => $record->marketingSources->map(fn($source) => $source->translated_name)->toArray())
              ->badge()
              ->placeholder(' لا يوجد')

              ->color('warning')
              ->placeholder('لم يتم تحديد أي مصدر'),

            TextEntry::make('expected_hourly_rate_usd')
              ->label('أجر الساعة المتوقع')
              ->placeholder(' لا يوجد')

              ->weight('bold')
              ->formatStateUsing(fn($record) => "$ {$record->expected_hourly_rate_usd} / {$record->expected_hourly_rate_syp} ل.س")
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; color: #10b981;']),

            TextEntry::make('payment_method')
              ->label('طريقة الدفع')
              ->color(fn($state) => match ($state) {
                'daily' => 'info',
                'weekly' => 'warning',
                'monthly' => 'success',
                default => 'gray',
              })
              ->formatStateUsing(fn($state) => match ($state) {
                'daily' => 'يومي',
                'weekly' => 'أسبوعي',
                'monthly' => 'شهري',
                default => $state,
              }),

          ])->columnSpanFull(),

        Section::make('بيانات النظام والإحالات')
          ->icon('heroicon-o-cog')
          ->columns(3)
          ->schema([
            TextEntry::make('code')
              ->label('رمز العامل الفريد (سيرفر)')
              ->placeholder('غير موثق بعد')
              ->weight('bold')
              ->fontFamily('mono')
              ->color('primary'),

            IconEntry::make('is_verified')
              ->label('حالة التوثيق')
              ->boolean()
              ->trueIcon('heroicon-m-check-circle')
              ->falseIcon('heroicon-m-x-circle')
              ->trueColor('success')
              ->falseColor('danger'),

            TextEntry::make('referralCode.code')
              ->label('كود الإحالة الخاص بالعامل')
              ->placeholder('لا يوجد كود إحالة')
              ->color('success')
              ->icon('heroicon-m-gift')
              ->copyable(),

            TextEntry::make('form_referral_code')
              ->label('سجل بكود إحالة رقم')
              ->placeholder('تسجيل مباشر (بدون كود)')
              ->color('info'),

            TextEntry::make('invited_by')
              ->label('تمت الدعوة بواسطة')
              ->placeholder('لا يوجد داعٍ (تسجيل مباشر)')
              ->icon('heroicon-m-user-plus')
              ->weight('bold')
              ->color('warning')
              ->state(function ($record) {
                if (empty($record->form_referral_code)) {
                  return null;
                }

                $referral = ReferralCode::with('referralable')->where('code', $record->form_referral_code)->first();

                if ($referral && $referral->referralable) {
                  $owner = $referral->referralable;

                  if ($owner instanceof Company) {
                    return $owner->company_name . ' (شركة)';
                  }

                  if ($owner instanceof Worker) {
                    return $owner->first_name . ' ' . $owner->last_name . ' (عامل)';
                  }
                }

                return $record->form_referral_code;
              }),

          ])->columnSpanFull(),

        Section::make('تفاصيل وخبرات إضافية')
          ->icon('heroicon-o-document-plus')
          ->compact()
          ->schema([
            TextEntry::make('other_professions')
              ->label('مهارات أو مهن أخرى يجيدها')
              ->placeholder('لا يوجد مهن إضافية مسجلة لهذا العامل'),
          ])->columnSpanFull(),


        Section::make('سجل تقييمات العامل')
          ->icon('heroicon-o-star')
          ->description('مراجعات تقييم الأداء والملاحظات والرايات الحمراء المسجلة للعامل.')
          ->schema([
            RepeatableEntry::make('ratings')
              ->label('التقييمات المسجلة')
              ->placeholder('لا توجد تقييمات مسجلة لهذا العامل حتى الآن.')
              ->columns(3)
              ->schema([
                TextEntry::make('user.name')
                  ->label('المقيّم')
                  ->icon('heroicon-m-user')
                  ->weight('bold'),

                TextEntry::make('created_at')
                  ->label('تاريخ التقييم')
                  ->dateTime('Y-m-d')
                  ->color('gray'),

                IconEntry::make('is_verified')
                  ->label('حالة توثيق التقييم')
                  ->boolean()
                  ->trueColor('success')
                  ->falseColor('warning'),

                TextEntry::make('skill_level')
                  ->label('مستوى المهارة')
                  ->badge()
                  ->color('primary'),

                TextEntry::make('communication_level')
                  ->label('مستوى التواصل')
                  ->badge()
                  ->color('info'),

                TextEntry::make('seriousness_level')
                  ->label('مستوى الجدية والالتزام')
                  ->badge()
                  ->color('success'),

                TextEntry::make('skill_matching')
                  ->label('مطابقة المهارة المطلوبة')
                  ->badge()
                  ->color('gray'),

                IconEntry::make('red_flag')
                  ->label('راية حمراء / تحذير')
                  ->boolean()
                  ->trueIcon('heroicon-m-flag')
                  ->falseIcon('heroicon-m-minus')
                  ->trueColor('danger')
                  ->falseColor('gray'),

                TextEntry::make('notes')
                  ->label('ملاحظات المقيّم')
                  ->placeholder('لا توجد تفاصيل إضافية')
                  ->columnSpanFull(),

                TextEntry::make('verification_notes')
                  ->label('ملاحظات التوثيق والإدارة')
                  ->placeholder('-')
                  ->visible(fn($state) => !empty($state))
                  ->columnSpanFull(),
              ])
              ->grid(2)
              ->columnSpanFull(),
          ])->columnSpanFull(),

        // Section::make('الوثائق والصور الشخصية المرفوعة')
        //   ->icon('heroicon-o-paper-clip')
        //   ->description('الصور الشخصية والأوراق الرسمية الثبوتية المرفوعة في سجل العامل.')
        //   ->schema([
        //     SpatieMediaLibraryImageEntry::make('image')
        //       ->label('الملفات والوثائق المتاحة')
        //       ->collection('workers')
        //       ->square()
        //       ->columnSpanFull()
        //       ->hintAction(
        //         Action::make('download_document')
        //           ->label('تحميل الملفات')
        //           ->icon('heroicon-m-arrow-down-tray')
        //           ->color('primary')
        //           ->visible(fn($record) => $record && $record->hasMedia('workers'))
        //           ->action(function ($record) {
        //             $media = $record->getFirstMedia('workers');
        //             if ($media) {
        //               return response()->download($media->getPath(), $media->file_name);
        //             }
        //           })
        //       )
        //   ])->columnSpanFull(),


        Section::make('الوثائق والمرفقات الرسمية')
          ->icon('heroicon-o-paper-clip')
          ->description('الأوراق الثبوتية والصور المرفوعة الخاصة بالشركة.')
          ->headerActions([
            Action::make('download_all')
              ->label('تحميل جميع الملفات (ZIP)')
              ->icon('heroicon-m-arrow-down-tray')
              ->color('primary')
              ->visible(fn($record) => $record && $record->media()->exists())
              ->action(function ($record) {
                $mediaCollection = $record->getMedia('workers');

                if ($mediaCollection->isEmpty()) {
                  return;
                }

                $zipFileName = 'company_' . $record->id . '_documents.zip';
                $zipPath = storage_path('app/public/' . $zipFileName);

                $zip = new ZipArchive;
                if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                  foreach ($mediaCollection as $media) {
                    if (file_exists($media->getPath())) {
                      $zip->addFile($media->getPath(), $media->file_name);
                    }
                  }
                  $zip->close();
                }

                return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
              })
          ])
          ->schema([
            RepeatableEntry::make('media')
              ->label('الملفات والمستندات المرفوعة')
              ->schema([
                ImageEntry::make('file_name')
                  ->label('')
                  ->visible(fn($record) => $record && str_starts_with($record->mime_type, 'image/'))
                  ->state(fn($record) => $record?->getUrl())
                  ->square()
                  ->size(80)
                  ->hintAction(
                    Action::make('download_img')
                      ->label('تحميل')
                      ->icon('heroicon-m-arrow-down-tray')
                      ->action(fn($record) => response()->download($record->getPath(), $record->file_name))
                  ),

                TextEntry::make('file_name')
                  ->label('')
                  ->icon('heroicon-o-document-text')
                  ->color('warning')
                  ->visible(fn($record) => $record && !str_starts_with($record->mime_type, 'image/'))
                  ->weight('bold')
                  ->hintAction(
                    Action::make('download_doc')
                      ->label('تحميل الملف')
                      ->icon('heroicon-m-arrow-down-tray')
                      ->action(fn($record) => response()->download($record->getPath(), $record->file_name))
                  ),
              ])
              ->grid(4)
              ->columnSpanFull(),
          ])->columnSpanFull(),


      ]);
  }
}
