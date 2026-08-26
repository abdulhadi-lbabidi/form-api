<?php

namespace App\Filament\Resources\Cashbacks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الإعلان')
          ->description('أدخل تفاصيل الإعلان بدقة.')
          ->icon('heroicon-o-gift')
          ->schema([
            TextInput::make('company_name')
              ->label('اسم الشركة')
              ->required()
              ->maxLength(255),

            TextInput::make('owner_name')
              ->label('اسم مالك الشركة')
              ->maxLength(255),

            TextInput::make('phone_number')
              ->label('رقم الهاتف')
              ->required()
              ->maxLength(255),


            Select::make('cashbackable_type')
              ->label('نوع الجهة المرتبطة')
              ->options([
                'App\Models\Company' => 'شركة (Company)',
                'App\Models\Worker'  => 'عامل (Worker)',
                'App\Models\Kadr'    => 'كادر (Kadr)',
              ])
              ->required()
              ->live()
              ->afterStateUpdated(fn(callable $set) => $set('cashbackable_id', null)),

            Select::make('cashbackable_id')
              ->label('الجهة المرتبطة')
              ->options(function (callable $get) {
                $type = $get('cashbackable_type');
                if (!$type || !class_exists($type)) {
                  return [];
                }

                $labelField = match ($type) {
                  'App\Models\Company' => 'company_name',
                  'App\Models\Worker'  => 'full_name',
                  'App\Models\Kadr'    => 'name',
                  default              => 'id',
                };

                return $type::pluck($labelField, 'id');
              })
              ->required()
              ->searchable()
              ->preload(),

            Select::make('categories')
              ->label('تصنيفات الإعلان')
              ->relationship('categories', 'name')
              ->multiple()
              ->searchable()
              ->preload()
              ->required()
              ->columnSpanFull(),

            TextInput::make('reasone')
              ->label('السبب')
              ->maxLength(255),

          ])->columnSpanFull(),
      ]);
  }
}
