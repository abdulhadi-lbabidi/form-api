<?php

namespace App\Filament\Resources\CashbackDeals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackDealForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات صفقة الإعلان')
          ->description('أدخل تفاصيل العرض والتواريخ والعمولة بدقة.')
          ->icon('heroicon-o-tag')
          ->schema([
            Grid::make(2)->schema([
              Select::make('cashback_id')
                ->label('الإعلان الترويجي (اسم الشركة)')
                ->relationship('cashback', 'company_name')
                ->required()
                ->searchable()
                ->preload()
                ->columnSpanFull(),

              TextInput::make('title')
                ->label('عنوان العرض')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

              TextInput::make('redirect_url')
                ->label('رابط التوجيه (Redirect URL)')
                ->url()
                ->maxLength(255)
                ->columnSpanFull(),

              Select::make('status')
                ->label('حالة العرض')
                ->options([
                  'active'   => 'نشط',
                  'inactive' => 'غير نشط',
                  'expired'  => 'منتهي',
                ])
                ->default('active')
                ->required()
                ->native(false)
                ->columnSpanFull(),

              Toggle::make('is_favorite')
                ->label('مفضلة (Favorite)')
                ->default(false)
                ->columnSpanFull(),

              DatePicker::make('start_date')
                ->label('تاريخ البداية')
                ->required(),

              DatePicker::make('end_date')
                ->label('تاريخ النهاية')
                ->required()
                ->after('start_date'),



              TextInput::make('comosion')
                ->label('قيمة أو نسبة العرض (العمولة)')
                ->numeric()
                ->required()
                ->suffix('المبلغ')
                ->columnSpanFull(),

              RichEditor::make('content')
                ->label('المحتوى / التفاصيل')
                ->columnSpanFull(),

              SpatieMediaLibraryFileUpload::make('images_content_deals')
                ->label('صور البوستر / المحتوى')
                ->collection('cashback-deals')
                ->disk('public')
                ->image()
                ->multiple()
                ->reorderable()
                ->panelLayout('grid')
                ->columnSpanFull(),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
