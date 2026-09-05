<?php

namespace App\Filament\Resources\KadrFeedback\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class KadrFeedbackInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل تقييم الكادر')
          ->description('معلومات تقييم الكادر والطرف المرتبط بالتقييم.')
          ->icon('heroicon-o-star')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('kadr.name')
                ->label('الكادر المقيم')
                ->placeholder('غير متوفر')
                ->weight('bold')
                ->icon('heroicon-m-user-group')
                ->color('primary')
                ->state(fn($record) => $record->kadr?->name ?? ($record->kadr?->first_name . ' ' . $record->kadr?->last_name)),

              TextEntry::make('stars')
                ->label('عدد النجوم')
                ->placeholder('-')
                ->badge()
                ->color('warning')
                ->formatStateUsing(fn($state) => "{$state} ⭐"),

              TextEntry::make('feedbackable_type')
                ->label('نوع الطرف المرتبط')
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'App\Models\Company' => 'شركة',
                  'App\Models\Worker'  => 'عامل',
                  'App\Models\User'    => 'مستخدم',
                  default              => $state,
                })
                ->badge()
                ->color('info'),

              TextEntry::make('feedbackable_id')
                ->label('معرف الطرف المرتبط (ID)')
                ->numeric()
                ->placeholder('-')
                ->color('gray'),
            ]),

            TextEntry::make('reason')
              ->label('السبب / الملاحظات')
              ->placeholder('لا توجد ملاحظات أو أسباب مسجلة لهذا التقييم.')
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('تواريخ النظام')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(2)
          ->schema([
            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->icon('heroicon-m-calendar')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

            TextEntry::make('updated_at')
              ->label('تاريخ التحديث')
              ->icon('heroicon-m-calendar')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
          ])->columnSpanFull(),
      ]);
  }
}
