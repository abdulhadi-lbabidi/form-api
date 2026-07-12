<?php

namespace App\Filament\Resources\ReferralCodes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReferralCodeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('تفاصيل كود الإحالة')
          ->description('معلومات تتبع كود الإحالة ونوع المستفيد منه ومعدلات استخدامه الحالية.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('code')
                ->label('كود الإحالة')
                ->weight('bold')
                ->fontFamily('mono')
                ->color('primary')
                ->copyable()
                ->copyMessage('تم نسخ كود الإحالة بنجاح')
                ->icon('heroicon-m-clipboard-document-check'),

              TextEntry::make('referralable_type')
                ->label('نوع الكيان المستفيد')
                ->formatStateUsing(fn($state) => $state === 'App\Models\Company' ? 'شركة' : 'عامل')
                ->color(fn($state) => $state === 'App\Models\Company' ? 'info' : 'purple'),

              TextEntry::make('owner_name')
                ->label('اسم صاحب الكود')
                ->icon('heroicon-m-user')
                ->state(function ($record) {
                  return $record->referralable?->company_name
                    ?? ($record->referralable ? "{$record->referralable->first_name} {$record->referralable->last_name}" : '-');
                }),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('times_used')
                ->label('الاستخدام الحالي / الحد الأقصى')
                ->icon('heroicon-m-arrow-trending-up')
                ->state(function ($record) {
                  $limit = $record->usage_limit ?? '∞';
                  return "{$record->times_used} / {$limit}";
                })
                ->color(fn($record) => $record->usage_limit && $record->times_used >= $record->usage_limit ? 'danger' : 'gray')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: bold;']),

              TextEntry::make('expires_at')
                ->label('تاريخ انتهاء الصلاحية')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A')
                ->placeholder('مفتوح الصلاحية (لا ينتهي)')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              IconEntry::make('is_active')
                ->label('حالة الكود بالنظام')
                ->boolean(),
            ]),
          ])->columnSpanFull(),

        Section::make('معلومات الشركة المالكية للكود')
          ->description('تفاصيل وبيانات الشركة المرتبطة بكود الإحالة هذا.')
          ->icon('heroicon-o-building-office-2')
          ->collapsible()
          ->visible(fn($record) => $record->referralable_type === 'App\Models\Company')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('referralable.company_name')
                ->label('اسم الشركة')
                ->weight('bold'),

              TextEntry::make('referralable.business_type')
                ->label('نوع العمل')

                ->color('gray'),

              TextEntry::make('referralable.code')
                ->label('رمز الشركة الرسمي')
                ->placeholder('غير موثق بعد')
                ->fontFamily('mono')
                ->color('primary'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('referralable.city')
                ->label('المدينة')
                ->icon('heroicon-m-map-pin'),

              TextEntry::make('referralable.work_location')
                ->label('الموقع التفصيلي')
                ->icon('heroicon-m-map-pin'),

              TextEntry::make('referralable.contact_person_name')
                ->label('الشخص المسؤول (Contact)')
                ->placeholder('لا يوجد')
                ->icon('heroicon-m-user'),
            ]),

            Grid::make(2)->schema([
              TextEntry::make('referralable.email')
                ->label('البريد الإلكتروني')
                ->icon('heroicon-m-envelope')
                ->placeholder('لا يوجد')
                ->copyable()
                ->url(fn($record) => $record->referralable?->email ? "mailto:{$record->referralable->email}" : null),

              TextEntry::make('referralable.phone_number')
                ->label('رقم الهاتف')
                ->icon('heroicon-m-phone')
                ->copyable()
                ->url(fn($record) => $record->referralable?->phone_number ? "tel:{$record->referralable->phone_number}" : null)
                ->extraAttributes(['style' => 'direction: ltr; text-align: right; font-variant-numeric: lnum; font-family: cairo;']),
            ]),

            Grid::make(1)->schema([
              TextEntry::make('referralable.problems_faced')
                ->label('المشاكل التي تواجهها الشركة')
                ->placeholder('لا توجد مشاكل مسجلة')
                ->markdown(),
            ]),
          ])->columnSpanFull(),

        Section::make('معلومات العامل المالك للكود')
          ->description('بيانات وتفاصيل العامل المرتبط بكود الإحالة هذا.')
          ->icon('heroicon-o-user')
          ->collapsible()
          ->visible(fn($record) => $record->referralable_type === 'App\Models\Worker')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('worker_name')
                ->label('الاسم الكامل')
                ->weight('bold')
                ->state(fn($record) => $record->referralable ? "{$record->referralable->first_name} {$record->referralable->father_name} {$record->referralable->last_name}" : '-'),

              TextEntry::make('referralable.primary_profession')
                ->label('المهنة الأساسية')

                ->color('purple'),

              TextEntry::make('referralable.code')
                ->label('رمز العامل')
                ->placeholder('غير موثق بعد')
                ->fontFamily('mono')
                ->color('primary'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('referralable.city')
                ->label('المدينة')
                ->icon('heroicon-m-map-pin'),

              TextEntry::make('referralable.residential_area')
                ->label('منطقة السكن')
                ->icon('heroicon-m-map-pin'),

              TextEntry::make('referralable.marital_status')
                ->label('الحالة الاجتماعية'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('referralable.phone_whatsapp')
                ->label('رقم الواتساب')
                ->icon('heroicon-m-phone')
                ->copyable()
                ->extraAttributes(['style' => 'direction: ltr; text-align: right; font-variant-numeric: lnum; font-family: cairo;']),

              TextEntry::make('referralable.age')
                ->label('تاريخ الميلاد')
                ->date('Y-m-d')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              IconEntry::make('referralable.is_verified')
                ->label('حالة التوثيق')
                ->boolean(),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('referralable.work_hours')
                ->label('ساعات العمل المتاحة'),

              TextEntry::make('referralable.commitment_level')
                ->label('مستوى الالتزام'),

              TextEntry::make('referralable.working_status')
                ->label('الحالة العملية الحالية'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('expected_rates')
                ->label('الأجر المتوقع (ساعة)')
                ->state(fn($record) => $record->referralable ? "{$record->referralable->expected_hourly_rate_usd} USD / {$record->referralable->expected_hourly_rate_syp} SYP" : '-')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              TextEntry::make('referralable.payment_method')
                ->label('طريقة الدفع المفضلة')

                ->color('gray'),
            ]),

            Grid::make(1)->schema([
              TextEntry::make('referralable.other_professions')
                ->label('المهن الأخرى المتقنة')
                ->placeholder('لا توجد مهن إضافية مسجلة'),
            ]),
          ])->columnSpanFull(),

      ]);
  }
}
