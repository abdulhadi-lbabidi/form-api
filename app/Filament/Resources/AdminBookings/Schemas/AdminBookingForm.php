<?php

namespace App\Filament\Resources\AdminBookings\Schemas;

use App\Models\Worker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminBookingForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الحجز الإداري')
          ->description('حدد المسؤول، وتاريخ الحجز، والفترة الزمنية، والشركات أو العمال المرتبطين.')
          ->icon('heroicon-o-calendar')
          ->columns(2)
          ->schema([
            Hidden::make('user_id')
              ->default(fn() => auth()->id())
              ->required(),

            TextInput::make('user_name_display')
              ->label('المسؤول عن الحجز')
              ->default(fn() => auth()->user()->name)
              ->disabled()
              ->dehydrated(false),

            Select::make('interviewer_id')
              ->label('الشخص الذي سيقوم بالمقابلة')
              ->relationship('interviewer', 'name')
              ->searchable()
              ->preload()
              ->required(),

            DatePicker::make('booking_date')
              ->label('تاريخ الحجز')
              ->required()
              ->native(false)
              ->displayFormat('Y-m-d')
              ->default(now())
              ->minDate(now()->startOfDay()),

            TimePicker::make('time_from')
              ->label('الوقت من')
              ->required()
              ->seconds(false),

            TimePicker::make('time_to')
              ->label('الوقت إلى')
              ->required()
              ->seconds(false),

            Select::make('companies')
              ->label('الشركات المرتبطة')
              ->relationship('companies', 'company_name')
              ->multiple()
              ->searchable()
              ->preload()
              ->columnSpanFull(),

            Select::make('workers')
              ->label('العمال المرتبطون')
              ->multiple()
              ->relationship('workers', 'full_name')
              ->getOptionLabelFromRecordUsing(fn(Worker $record) => $record->full_name ?? 'عامل  بدون اسم')
              ->searchable()
              ->preload(),

            Select::make('status')
              ->label('حالة الحجز')
              ->options([
                'pending' => 'قيد الانتظار',
                'active' => 'نشط',
                'canceled' => 'ملغي',
                'completed' => 'تمت المقابلة',
              ])
              ->default('pending')
              ->required()
              ->native(false),

            Textarea::make('notes')
              ->label('ملاحظات إضافية')
              ->placeholder('اكتب هنا أي تفاصيل أو ملاحظات متعلقة بالحجز الإداري...')
              ->columnSpanFull(),


          ])->columnSpanFull(),
      ]);
  }
}
