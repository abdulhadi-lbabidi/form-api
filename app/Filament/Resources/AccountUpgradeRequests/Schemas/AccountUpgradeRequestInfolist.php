<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccountUpgradeRequestInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل طلب الترقية')
          ->description('عرض كافة تفاصيل طلب الترقية المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('morphable_type')
                ->label('نوع الجهة')
                ->formatStateUsing(fn($state) => match ($state) {
                  'App\Models\Company' => 'شركة',
                  'App\Models\Worker'  => 'عامل',
                  'App\Models\Kadr'    => 'كادر',
                  default              => $state,
                })
                ->badge()
                ->color('warning')
                ->icon('heroicon-m-tag'),

              TextEntry::make('morphable')
                ->label('اسم الجهة صاحبة الطلب')
                ->getStateUsing(function ($record) {
                  if (!$record->morphable) return 'غير متوفر';

                  return match (get_class($record->morphable)) {
                    'App\Models\Company' => $record->morphable->company_name ?? 'شركة #' . $record->morphable->id,
                    'App\Models\Worker'  => $record->morphable->full_name ?? 'عامل #' . $record->morphable->id,
                    'App\Models\Kadr'    => $record->morphable->name ?? 'كادر #' . $record->morphable->id,
                    default              => 'معرف #' . $record->morphable->id,
                  };
                })
                ->badge()
                ->color('success')
                ->icon('heroicon-m-user'),

              TextEntry::make('status')
                ->label('حالة الطلب')
                ->formatStateUsing(fn($state) => match ($state) {
                  'pending'   => 'قيد الانتظار',
                  'approved'  => 'تم الموافقة',
                  'rejected'  => 'مرفوض',
                  default     => $state,
                })
                ->badge()
                ->color(fn($state) => match ($state) {
                  'approved'  => 'success',
                  'pending'   => 'warning',
                  'rejected'  => 'danger',
                  default     => 'gray',
                }),

              TextEntry::make('created_at')
                ->label('تاريخ الإنشاء')
                ->dateTime('Y-m-d H:i')
                ->icon('heroicon-m-calendar'),

              TextEntry::make('notes')
                ->label('ملاحظات')
                ->placeholder('لا توجد ملاحظات')
                ->columnSpanFull()
                ->icon('heroicon-m-document-text'),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
