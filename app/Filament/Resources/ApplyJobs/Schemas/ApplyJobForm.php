<?php

namespace App\Filament\Resources\ApplyJobs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
            'App\Models\CompanyJobHosting' => 'وظيفة شركة (Company Job)',
            'App\Models\KadrJobHosting' => 'وظيفة كادر (Kadr Job)',
          ])
          ->required()
          ->label('نوع الوظيفة'),

        TextInput::make('jobable_id')
          ->required()
          ->numeric()
          ->label('معرف الوظيفة (Job ID)'),

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
