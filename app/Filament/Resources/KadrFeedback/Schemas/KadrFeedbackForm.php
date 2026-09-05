<?php

namespace App\Filament\Resources\KadrFeedback\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;

class KadrFeedbackForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Grid::make(2)->schema([
          Select::make('kadr_id')
            ->label('الكادر المقيم')
            ->relationship('kadr', 'name')
            ->getOptionLabelFromRecordUsing(fn($record) => $record->name ?? ($record->first_name . ' ' . $record->last_name) ?? 'كادر بدون اسم')
            ->searchable()
            ->preload()
            ->placeholder('ابحث واختر الكادر...')
            ->required(),

          TextInput::make('stars')
            ->label('عدد النجوم')
            ->numeric()
            ->minValue(0)
            ->maxValue(5)
            ->step(0.1)
            ->default(5)
            ->required()
            ->suffix('⭐'),
        ]),

        Select::make('feedbackable_type')
          ->label('نوع الطرف المرتبط بالتقييم')
          ->options([
            'App\Models\Company' => 'شركة',
            'App\Models\Worker'  => 'عامل',
            'App\Models\User'    => 'مستخدم',
          ])
          ->reactive()
          ->afterStateUpdated(fn(callable $set) => $set('feedbackable_id', null))
          ->required()
          ->placeholder('اختر نوع الطرف...')
          ->columnSpanFull(),

        Select::make('feedbackable_id')
          ->label('الطرف المستهدف')
          ->searchable()
          ->preload()
          ->required()
          ->options(function (Get $get) {
            $type = $get('feedbackable_type');

            if (!$type) {
              return [];
            }

            return match ($type) {
              \App\Models\Company::class => \App\Models\Company::query()
                ->get()
                ->mapWithKeys(fn($company) => [$company->id => $company->company_name ?? 'شركة بدون اسم'])
                ->toArray(),

              \App\Models\Worker::class => \App\Models\Worker::query()
                ->get()
                ->mapWithKeys(fn($worker) => [$worker->id => $worker->name ?? $worker->full_name ?? 'عامل بدون اسم'])
                ->toArray(),

              \App\Models\User::class => \App\Models\User::query()
                ->get()
                ->mapWithKeys(fn($user) => [$user->id => $user->name])
                ->toArray(),

              default => [],
            };
          })
          ->disabled(fn(Get $get) => !filled($get('feedbackable_type')))
          ->placeholder(fn(Get $get) => filled($get('feedbackable_type')) ? 'اختر الطرف...' : 'اختر نوع الطرف أولاً...')
          ->columnSpanFull(),

        Textarea::make('reason')
          ->label('السبب / الملاحظات')
          ->placeholder('اكتب تفاصيل التقييم أو الملاحظات هنا...')
          ->columnSpanFull(),
      ]);
  }
}
