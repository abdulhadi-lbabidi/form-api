<?php

namespace App\Filament\Resources\Ratings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class RatingForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('معلومات التقييم الأساسية')
          ->icon('heroicon-o-star')
          ->description('أدخل تفاصيل تقييم العامل ومستوى أدائه.')
          ->columnSpanFull()
          ->schema([
            Select::make('worker_id')
              ->relationship('worker', 'first_name')
              ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name} ({$record->phone_whatsapp})")
              ->label('العامل المستهدف')
              ->searchable(['first_name', 'last_name', 'phone_whatsapp'])
              ->preload()
              ->required(),

            Select::make('user_id')
              ->relationship('user', 'name')
              ->label('الشخص الذي قام بالتقييم')
              ->default(fn() => Auth::id())
              ->disabled()
              ->dehydrated()
              ->required(),
          ]),

        Section::make('معايير التقييم والمهارة')
          ->icon('heroicon-o-adjustments-horizontal')
          ->columns(3)
          ->columnSpanFull()
          ->schema([
            Select::make('seriousness_level')
              ->label('مستوى الجدية')
              ->options(array_combine(range(1, 5), range(1, 5)))
              ->required(),

            Select::make('skill_level')
              ->label('مستوى المهارة')
              ->options(array_combine(range(1, 5), range(1, 5)))
              ->required(),

            Select::make('communication_level')
              ->label('وضوح التواصل')
              ->options(array_combine(range(1, 5), range(1, 5)))
              ->required(),

            Select::make('skill_matching')
              ->label('تطابق المهارة')
              ->options([
                'matched' => 'متطابق',
                'partially_matched' => 'متطابق جزئياً',
                'not_matched' => 'غير متطابق',
              ])
              ->required()
              ->columnSpanFull(),
          ]),

        Section::make('ملاحظات والتحقق')
          ->icon('heroicon-o-document-check')
          ->columns(2)
          ->columnSpanFull()
          ->schema([
            Toggle::make('is_verified')
              ->label('متحقق / معتمد للعامة')
              ->onColor('success')
              ->offColor('danger')
              ->columnSpanFull(),

            TextInput::make('red_flag')
              ->label('مؤشر خطر (Red Flag)')
              ->placeholder('مثال: تأخر عن الموعد، عدم التزام بالاتفاق...')
              ->prefixIcon('heroicon-o-flag')
              ->prefixIconColor('danger')
              ->columnSpanFull(),

            Textarea::make('notes')
              ->label('ملاحظات عامة حول التقييم')
              ->rows(3)
              ->placeholder('اكتب ملاحظاتك هنا...'),

            Textarea::make('verification_notes')
              ->label('ملاحظات عملية التحقق')
              ->rows(3)
              ->placeholder('اكتب هنا ملاحظات المشرف حول صحة التقييم...'),
          ]),
      ]);
  }
}
