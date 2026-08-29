<?php

namespace App\Filament\Resources\ApplyJobs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplyJobForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('worker_id')
          ->relationship('worker', 'full_name')
          ->searchable()
          ->preload()
          ->required()
          ->label('العامل'),

        Select::make('jobable_type')
          ->options([
            \App\Models\CompanyJobHosting::class => 'وظيفة شركة (Company Job)',
            \App\Models\KadrJobHosting::class => 'وظيفة كادر (Kadr Job)',
          ])
          ->required()
          ->live()
          ->afterStateUpdated(fn(callable $set) => $set('jobable_id', null))
          ->label('نوع الوظيفة'),

        Select::make('jobable_id')
          ->label('اختر الوظيفة')
          ->options(function (callable $get) {
            $jobableType = $get('jobable_type');

            if (!$jobableType) {
              return [];
            }

            return $jobableType::query()->pluck('title', 'id');
          })
          ->searchable()
          ->preload()
          ->required()
          ->disabled(fn(callable $get) => !$get('jobable_type')),

        Select::make('status')
          ->options([
            'pending' => 'قيد الانتظار (Pending)',
            'accepted' => 'مقبول (Accepted)',
            'rejected' => 'مرفوض (Rejected)',
          ])
          ->required()
          ->default('pending')
          ->label('حالة الطلب'),

        Textarea::make('notes')
          ->columnSpanFull()
          ->label('ملاحظات'),
      ]);
  }
}
