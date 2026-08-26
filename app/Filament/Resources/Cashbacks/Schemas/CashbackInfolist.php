<?php

namespace App\Filament\Resources\Cashbacks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الإعلان')
          ->description('عرض كافة تفاصيل الإعلان المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('company_name')
                ->label('اسم الشركة')
                ->weight('bold')
                ->color('primary')
                ->icon('heroicon-m-building-office'),

              TextEntry::make('owner_name')
                ->label('اسم مالك الشركة')
                ->placeholder('لا يوجد')
                ->icon('heroicon-m-user'),

              TextEntry::make('phone_number')
                ->label('رقم الهاتف')
                ->placeholder('لا يوجد')
                ->icon('heroicon-m-phone'),

              TextEntry::make('reasone')
                ->label('السبب')
                ->placeholder('لا يوجد')
                ->icon('heroicon-m-document-text'),

              TextEntry::make('cashbackable_type')
                ->label('نوع الجهة المرتبطة')
                ->formatStateUsing(function ($state) {
                  return match ($state) {
                    'App\Models\Company' => 'شركة',
                    'App\Models\Worker'  => 'عامل',
                    'App\Models\Kadr'    => 'كادر',
                    default              => $state,
                  };
                })
                ->badge()
                ->color('warning')
                ->icon('heroicon-m-tag'),

              TextEntry::make('cashbackable')
                ->label('اسم الجهة المرتبطة')
                ->getStateUsing(function ($record) {
                  if (!$record->cashbackable) return 'غير متوفر';

                  return match (get_class($record->cashbackable)) {
                    'App\Models\Company' => $record->cashbackable->company_name ?? 'شركة #' . $record->cashbackable->id,
                    'App\Models\Worker'  => $record->cashbackable->full_name ?? 'عامل #' . $record->cashbackable->id,
                    'App\Models\Kadr'    => $record->cashbackable->name ?? 'كادر #' . $record->cashbackable->id,
                    default              => 'معرف #' . $record->cashbackable->id,
                  };
                })
                ->badge()
                ->color('success')
                ->icon('heroicon-m-user'),


              TextEntry::make('categories.name')
                ->label('التصنيفات')
                ->badge()
                ->color('info')
                ->placeholder('لا توجد تصنيفات')
                ->icon('heroicon-m-tag')
                ->columnSpanFull(),



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
