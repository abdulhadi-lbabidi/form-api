<?php

namespace App\Filament\Resources\WorkerFeedback\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class WorkerFeedbackInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل تقييم العامل')
          ->description('معلومات تقييم العامل والجهة المرتبطة بالتقييم.')
          ->icon('heroicon-o-star')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('worker.full_name')
                ->label('العامل')
                ->placeholder('غير متوفر')
                ->weight('bold')
                ->icon('heroicon-m-user')
                ->color('primary'),

              TextEntry::make('stars')
                ->label('عدد النجوم')
                ->placeholder('-')
                ->badge()
                ->color('warning')
                ->formatStateUsing(fn($state) => "{$state} ⭐"),

              TextEntry::make('feedbackable_type')
                ->label('نوع الجهة المرتبطة')
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'App\Models\Company' => 'شركة',
                  'App\Models\Kadr'    => 'كادر',
                  'App\Models\User'    => 'مستخدم',
                  default              => $state,
                })
                ->badge()
                ->color('info'),

              TextEntry::make('feedbackable_id')
                ->label('معرف الجهة المرتبطة (ID)')
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
