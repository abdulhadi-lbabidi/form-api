<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccountUpgradeRequestForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات طلب الترقية')
          ->description('أدخل أو عدل تفاصيل طلب ترقية الحساب والجهة صاحبة الطلب.')
          ->icon('heroicon-o-document-text')
          ->schema([
            Select::make('morphable_type')
              ->label('نوع الجهة')
              ->options([
                'App\Models\Company' => 'شركة (Company)',
                'App\Models\Worker'  => 'عامل (Worker)',
                'App\Models\Kadr'    => 'كادر (Kadr)',
              ])
              ->required()
              ->live()
              ->afterStateUpdated(fn(callable $set) => $set('morphable_id', null)),

            Select::make('morphable_id')
              ->label('اسم الجهة')
              ->options(function (callable $get) {
                $type = $get('morphable_type');
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

            Select::make('status')
              ->label('حالة الطلب')
              ->options([
                'pending'   => 'قيد الانتظار',
                'approved'  => 'تم الموافقة',
                'rejected'  => 'مرفوض',
              ])
              ->required()
              ->default('pending')
              ->native(false),

            Textarea::make('notes')
              ->label('ملاحظات')
              ->placeholder('أدخل أي ملاحظات إضافية هنا...')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
