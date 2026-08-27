<?php

namespace App\Filament\Resources\ApplyJobs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApplyJobInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل طلب التقديم')
          ->description('عرض معلومات طلب التقديم على الوظيفة بالكامل.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('worker.full_name')
                ->label('اسم العامل')
                ->icon('heroicon-m-user'),

              TextEntry::make('worker.phone_whatsapp')
                ->label('واتساب العامل')
                ->icon('heroicon-m-phone'),

              TextEntry::make('jobable_type')
                ->label('نوع الوظيفة')
                ->formatStateUsing(fn(string $state): string => class_basename($state))
                ->badge()
                ->color('info')
                ->icon('heroicon-m-briefcase'),

              TextEntry::make('jobable_id')
                ->label('اسم الوظيفة')
                ->state(function ($record) {
                  return $record->jobable?->title ?? 'غير متوفرة';
                })
                ->badge()
                ->color('gray')
                ->icon('heroicon-m-bookmark'),

              TextEntry::make('status')
                ->label('الحالة')
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'pending' => 'قيد الانتظار',
                  'accepted' => 'مقبول',
                  'rejected' => 'مرفوض',
                  default => $state,
                })
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                  'pending' => 'warning',
                  'accepted' => 'success',
                  'rejected' => 'danger',
                  default => 'gray',
                }),

              TextEntry::make('created_at')
                ->label('تاريخ التقديم')
                ->dateTime('Y-m-d H:i')
                ->icon('heroicon-m-clock'),

              TextEntry::make('updated_at')
                ->label('آخر تحديث')
                ->dateTime('Y-m-d H:i')
                ->icon('heroicon-m-arrow-path'),
            ]),
          ])->columnSpanFull(),

        Section::make('ملاحظات إضافية')
          ->description('ملاحظات المتقدم حول الوظيفة.')
          ->icon('heroicon-o-chat-bubble-bottom-center-text')
          ->schema([
            TextEntry::make('notes')
              ->label('')
              ->placeholder('-')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
