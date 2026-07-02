<?php

namespace App\Filament\Resources\Ratings\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RatingInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل أطراف التقييم')
          ->icon('heroicon-o-user-group')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('worker.full_name')
                ->label('العامل المُقيّم')
                ->state(fn($record) => $record->worker ? "{$record->worker->first_name} {$record->worker->last_name}" : '-')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('user.name')
                ->label('المُقيِّم (صاحب العمل/المستخدم)')
                ->weight('bold'),
            ]),
          ])->columnSpanFull(),

        Section::make('الدرجات والتقييمات الرقمية')
          ->icon('heroicon-o-bars-3-bottom-left')
          ->columns(3)
          ->schema([
            TextEntry::make('seriousness_level')
              ->label('مستوى الجدية')
              ->formatStateUsing(fn($state) => "⭐ {$state} / 5")
              ->extraAttributes(['style' => 'font-weight: bold; color: #eab308;']),

            TextEntry::make('skill_level')
              ->label('مستوى المهارة')
              ->formatStateUsing(fn($state) => "⭐ {$state} / 5")
              ->extraAttributes(['style' => 'font-weight: bold; color: #eab308;']),

            TextEntry::make('communication_level')
              ->label('وضوح التواصل')
              ->formatStateUsing(fn($state) => "⭐ {$state} / 5")
              ->extraAttributes(['style' => 'font-weight: bold; color: #eab308;']),

            TextEntry::make('skill_matching')
              ->label('تطابق المهارة')
              ->badge()
              ->color(fn($state) => match ($state) {
                'matched' => 'success',
                'partially_matched' => 'warning',
                'not_matched' => 'danger',
                default => 'gray'
              })
              ->formatStateUsing(fn($state) => match ($state) {
                'matched' => 'متطابق',
                'partially_matched' => 'متطابق جزئياً',
                'not_matched' => 'غير متطابق',
                default => $state
              })
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('حالة التوثيق والملاحظات')
          ->icon('heroicon-o-clipboard-document-list')
          ->columns(2)
          ->schema([
            IconEntry::make('is_verified')
              ->label('حالة التحقق')
              ->boolean()
              ->trueIcon('heroicon-m-check-circle')
              ->falseIcon('heroicon-m-x-circle')
              ->trueColor('success')
              ->falseColor('danger')
              ->columnSpanFull(),

            TextEntry::make('red_flag')
              ->label('مؤشر خطر (Red Flag)')
              ->placeholder('لا توجد علامات حمراء مسجلة.')
              ->color('danger')
              ->icon('heroicon-m-flag')
              ->weight('bold')
              ->columnSpanFull(),

            TextEntry::make('notes')
              ->label('ملاحظات نصية')
              ->placeholder('لا يوجد ملاحظات عامة مضافة.'),

            TextEntry::make('verification_notes')
              ->label('ملاحظات التحقق')
              ->placeholder('لا توجد ملاحظات تدقيق للتحقق بعد.'),
          ])->columnSpanFull(),
      ]);
  }
}
