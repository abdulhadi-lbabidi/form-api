<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;

class CompanyInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل سجل الشركة')
          ->description('المعلومات الأساسية وبيانات الاتصال والموقع الرئيسي للشركة.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('company_name')
                ->label('اسم الشركة')
                ->weight('bold'),

              TextEntry::make('business_type')
                ->label('نوع العمل')
                ->badge()
                ->color('gray'),

              TextEntry::make('owner_name')
                ->label('اسم المالك')
                ->icon('heroicon-m-user'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('work_location')
                ->label('موقع العمل')
                ->icon('heroicon-m-map-pin')
                ->color('primary'),

              TextEntry::make('email')
                ->label('البريد الإلكتروني')
                ->icon('heroicon-m-envelope')
                ->color('info')
                ->copyable()
                ->copyMessage('تم نسخ البريد الإلكتروني')
                ->url(fn($record) => "mailto:{$record->email}"),

              TextEntry::make('phone_number')
                ->label('رقم الهاتف')
                ->icon('heroicon-m-phone')
                ->color('success')
                ->copyable()
                ->copyMessage('تم نسخ رقم الهاتف')
                ->url(fn($record) => "tel:{$record->phone_number}")
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: bold;']),
            ]),

            TextEntry::make('problems_faced')
              ->label('المشاكل التي تواجهها الشركة (إن وجدت)')
              ->placeholder('لا توجد مشاكل مسجلة أو تحديات تواجه سير العمل حالياً.')
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('التواريخ والنظام')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(3)
          ->schema([

            TextEntry::make('code')
              ->label('رمز الشركة الفريد')
              ->placeholder('لم يتم التوليد (غير موثقة)')
              ->fontFamily('mono')
              ->weight('bold')
              ->color('primary')
              ->icon('heroicon-m-qr-code')
              ->copyable()
              ->copyMessage('تم نسخ الرمز بنجاح'),

            IconEntry::make('is_verified')
              ->label('حالة التوثيق')
              ->boolean()
              ->trueIcon('heroicon-m-check-circle')
              ->falseIcon('heroicon-m-x-circle')
              ->trueColor('success')
              ->falseColor('danger'),


            TextEntry::make('created_at')
              ->label('تاريخ تسجيل الشركة')
              ->icon('heroicon-m-calendar')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
          ])->columnSpanFull(),

        Section::make('الوثائق والمرفقات الرسمية')
          ->icon('heroicon-o-paper-clip')
          ->description('الأوراق الثبوتية والصور المرفوعة الخاصة بالشركة.')
          ->schema([
            SpatieMediaLibraryImageEntry::make('image')
              ->label('الملفات المستندة')
              ->collection('companies')
              ->square()
              ->columnSpanFull()

          ])->columnSpanFull(),
      ]);
  }
}
