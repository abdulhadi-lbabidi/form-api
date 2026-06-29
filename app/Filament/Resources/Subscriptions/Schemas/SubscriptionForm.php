<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الاشتراك')
          ->description('اختر الفترة الزمنية وحدد حالة الاشتراك الحالية.')
          ->icon('heroicon-o-credit-card')
          ->columns(2)
          ->schema([
            Select::make('time_id')
              ->label('الفترة الزمنية')
              ->relationship('time', 'work_time')
              ->required()
              ->searchable()
              ->preload()
              ->disableOptionWhen(function ($value, $record) {
                $isReserved = \App\Models\Subscription::where('time_id', $value)
                  ->whereIn('status', ['active', 'pending'])
                  ->whereDate('created_at', now()->toDateString())
                  ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                  ->exists();

                return $isReserved;
              }),

            Select::make('status')
              ->label('حالة الاشتراك')
              ->options([
                'pending' => 'قيد الانتظار',
                'active' => 'نشط',
                'canceled' => 'ملغي',
              ])
              ->required()
              ->default('pending'),

            Textarea::make('note')
              ->label('ملاحظات إضافية')
              ->placeholder('اكتب هنا أي ملاحظات أو تفاصيل متعلقة بالاشتراك...')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
