<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class CompaniesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        IconColumn::make('is_verified')
          ->label('التوثيق')
          ->boolean()
          ->trueIcon('heroicon-m-check-circle')
          ->falseIcon('heroicon-m-x-circle')
          ->trueColor('success')
          ->falseColor('danger'),

        TextColumn::make('code')
          ->label('رمز الشركة')
          ->searchable()
          ->sortable()
          ->placeholder('غير موثق بعد')
          ->weight('bold')
          ->fontFamily('mono')
          ->color('primary'),


        TextColumn::make('company_name')
          ->label('اسم الشركة')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('owner_name')
          ->label('المالك')
          ->placeholder('لا يوجد')
          ->searchable()
          ->icon('heroicon-m-user'),

        TextColumn::make('contact_person_name')
          ->label(' المسؤول عن التواصل')
          ->placeholder('لا يوجد')
          ->searchable()
          ->sortable()
          ->weight('bold'),


        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->icon('heroicon-m-map-pin')
          ->color('primary'),

        TextColumn::make('business_type')
          ->label('نوع العمل')
          ->searchable()
          ->toggleable()
          ->badge()
          ->color('gray'),



        TextColumn::make('work_location')
          ->label('الموقع')
          ->searchable()
          ->icon('heroicon-m-map-pin')
          ->color('primary'),

        TextColumn::make('email')
          ->label('البريد الإلكتروني')
          ->searchable()
          ->icon('heroicon-m-envelope')
          ->placeholder('لا يوجد')
          ->copyable()
          ->copyMessage('تم نسخ البريد الإلكتروني')
          ->url(fn($record) => "mailto:{$record->email}"),

        TextColumn::make('phone_number')
          ->label('رقم الهاتف')
          ->searchable()
          ->icon('heroicon-m-phone')
          ->copyable()
          ->copyMessage('تم نسخ رقم الهاتف')
          ->url(fn($record) => "tel:{$record->phone_number}")
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

        TextColumn::make('form_referral_code')
          ->label('كود الإحالة المُستخدَم')
          ->searchable()
          ->placeholder('لا يوجد')
          ->toggleable(isToggledHiddenByDefault: true),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->searchable()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true)
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->headerActions([
        // ExportAction::make()
        //   ->label('تصدير الكل لإكسيل')
        //   ->color('success')
        //   ->icon('heroicon-m-arrow-down-tray'),

        // ImportAction::make()
        //   ->importer(CompanyImporter::class)
        //   ->label('استيراد من إكسيل')
        //   ->color('info')
        //   ->icon('heroicon-m-arrow-up-tray'),
      ])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
          // ExportBulkAction::make()
          //   ->label('تصدير المحدد إلى Excel')
          //   ->color('success'),
        ]),
      ]);
  }
}
