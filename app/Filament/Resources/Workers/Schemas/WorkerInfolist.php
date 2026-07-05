<?php

namespace App\Filament\Resources\Workers\Schemas;

use App\Models\ReferralCode;
use App\Models\Company;
use App\Models\Worker;
use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Illuminate\Support\Carbon;

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
                ->weight('bold'),
              TextEntry::make('last_name')
                ->label('العائلة')
                ->weight('bold'),
              TextEntry::make('father_name')
                ->label('اسم الأب'),
              TextEntry::make('mother_fullname')
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
                ->badge()
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
              ->icon('heroicon-m-map-pin')
              ->color('primary'),

            TextEntry::make('residential_area')
              ->label('المنطقة / السكن')
              ->icon('heroicon-m-map'),

            TextEntry::make('primary_profession')
              ->label('المهنة الأساسية')
              ->icon('heroicon-m-briefcase')
              ->weight('bold'),

            TextEntry::make('work_hours')
              ->label('ساعات العمل المتاحة')
              ->icon('heroicon-m-clock'),

            TextEntry::make('commitment_level')
              ->label('مستوى الالتزام')
              ->badge()
              ->color('gray'),

            TextEntry::make('working_status')
              ->label('حالة العمل الحالية')
              ->badge()
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

            TextEntry::make('expected_hourly_rate_usd')
              ->label('أجر الساعة المتوقع')
              ->weight('bold')
              ->formatStateUsing(fn($record) => "$ {$record->expected_hourly_rate_usd} / {$record->expected_hourly_rate_syp} ل.س")
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; color: #10b981;']),

            TextEntry::make('payment_method')
              ->label('طريقة الدفع')
              ->badge()
              ->color(fn($state) => $state === 'weekly' ? 'warning' : 'success')
              ->formatStateUsing(fn($state) => $state === 'weekly' ? 'أسبوعي' : 'شهري'),
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
              ->badge()
              ->color('success')
              ->icon('heroicon-m-gift')
              ->copyable(),

            TextEntry::make('form_referral_code')
              ->label('سجل بكود إحالة رقم')
              ->placeholder('تسجيل مباشر (بدون كود)')
              ->badge()
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

        Section::make('الوثائق والصور الشخصية المرفوعة')
          ->icon('heroicon-o-paper-clip')
          ->description('الصور الشخصية والأوراق الرسمية الثبوتية المرفوعة في سجل العامل.')
          ->schema([
            SpatieMediaLibraryImageEntry::make('image')
              ->label('الملفات والوثائق المتاحة')
              ->collection('workers')
              ->square()
              ->columnSpanFull()
              ->hintAction(
                Action::make('download_document')
                  ->label('تحميل الملفات')
                  ->icon('heroicon-m-arrow-down-tray')
                  ->color('primary')
                  ->visible(fn($record) => $record && $record->hasMedia('workers'))
                  ->action(function ($record) {
                    $media = $record->getFirstMedia('workers');
                    if ($media) {
                      return response()->download($media->getPath(), $media->file_name);
                    }
                  })
              )
          ])->columnSpanFull(),

      ]);
  }
}
