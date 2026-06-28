<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
              ->relationship('time', 'work_time') // يعرض وقت العمل بدلاً من الرقم
              ->required()
              ->searchable()
              ->preload(),

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
