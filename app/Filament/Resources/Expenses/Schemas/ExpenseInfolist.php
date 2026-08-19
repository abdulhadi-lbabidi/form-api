<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExpenseInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل المصروف')
          ->description('عرض كافة تفاصيل المصروف المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('name')
                ->label('اسم المصروف / البيان')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('amount')
                ->label('المبلغ')
                ->numeric()
                ->weight('bold')
                ->color('success'),

              TextEntry::make('creator.name')
                ->label('أُضيف بواسطة')
                ->placeholder('غير معروف')
                ->icon('heroicon-m-user'),

              TextEntry::make('created_at')
                ->label('تاريخ ووقت الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-calendar')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
