<?php

namespace App\Filament\Resources\Marketings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MarketingInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('بيانات المصدر التسويقي')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('translated_name')
                ->label('اسم المصدر الحالي')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('name.ar')
                ->label('الاسم بالعربية')
                ->color('gray'),

              TextEntry::make('name.en')
                ->label('الاسم بالإنجليزية')
                ->color('gray'),
            ]),

            Grid::make(2)->schema([
              TextEntry::make('workers_count')
                ->label('عدد العمال المسجلين عبره')
                ->badge()
                ->color('success')
                ->state(fn($record) => $record->workers()->count() . ' عامل'),

              TextEntry::make('companies_count')
                ->label('عدد الشركات المسجلة عبره')
                ->badge()
                ->color('info')
                ->state(fn($record) => $record->companies()->count() . ' شركة'),
            ]),
          ])->columnSpanFull(),

        Section::make('النظام والتواريخ')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(2)
          ->schema([
            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

            TextEntry::make('updated_at')
              ->label('آخر تحديث')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
          ])->columnSpanFull(),
      ]);
  }
}
