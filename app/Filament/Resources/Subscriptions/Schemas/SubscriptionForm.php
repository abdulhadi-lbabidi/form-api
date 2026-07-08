<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Models\Company;
use App\Models\Subscription;
use App\Models\Worker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SubscriptionForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الاشتراك')
          ->description('ابحث عن اسم المشترك مباشرة وحدد التاريخ والفترة الزمنية.')
          ->icon('heroicon-o-credit-card')
          ->columns(2)
          ->schema([

            Select::make('subscribable_combined')
              ->label('ابحث عن المشترك (شركة أو عامل)')
              ->required()
              ->searchable()
              ->preload()
              ->options(function (): array {
                $companies = Company::limit(15)
                  ->get()
                  ->mapWithKeys(fn($c) => ["App\Models\Company:{$c->id}" => "🏢 شركة: {$c->company_name}"])
                  ->toArray();

                $workers = Worker::limit(15)
                  ->get()
                  ->mapWithKeys(fn($w) => ["App\Models\Worker:{$w->id}" => "👤 عامل: {$w->first_name} {$w->last_name}"])
                  ->toArray();

                return $companies + $workers;
              })
              ->getSearchResultsUsing(function (string $search): array {
                $companies = Company::where('company_name', 'like', "%{$search}%")
                  ->limit(15)
                  ->get()
                  ->mapWithKeys(fn($c) => ["App\Models\Company:{$c->id}" => "🏢 شركة: {$c->company_name}"])
                  ->toArray();

                $workers = Worker::where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->limit(15)
                  ->get()
                  ->mapWithKeys(fn($w) => ["App\Models\Worker:{$w->id}" => "👤 عامل: {$w->first_name} {$w->last_name}"])
                  ->toArray();

                return $companies + $workers;
              })
              ->getOptionLabelUsing(function ($value): ?string {
                if (empty($value)) return null;
                [$type, $id] = explode(':', $value);

                if (!class_exists($type)) return null;

                $model = $type::find($id);
                if (!$model) return null;

                return $type === Company::class
                  ? "🏢 شركة: {$model->company_name}"
                  : "👤 عامل: {$model->first_name} {$model->last_name}";
              })
              ->afterStateHydrated(function (Select $component, $record) {
                if ($record && $record->subscribable_type && $record->subscribable_id) {
                  $component->state("{$record->subscribable_type}:{$record->subscribable_id}");
                }
              }),

            DatePicker::make('date')
              ->label('تاريخ الحجز')
              ->required()
              ->native(false)
              ->displayFormat('Y-m-d')
              ->minDate(now()->startOfDay())
              ->live(),

            Select::make('time_id')
              ->label('الفترة الزمنية')
              ->relationship('time', 'work_time')
              ->required()
              ->searchable()
              ->preload()
              ->disabled(fn(Get $get) => empty($get('date')))
              ->disableOptionWhen(function ($value, Get $get, $record) {
                $selectedDate = $get('date');

                if (empty($selectedDate)) {
                  return false;
                }

                return Subscription::where('time_id', $value)
                  ->where('date', $selectedDate)
                  ->whereIn('status', ['active', 'pending'])
                  ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                  ->exists();
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

            TextInput::make('phone_number')
              ->label('رقم الهاتف')
              ->maxLength(20)
              ->placeholder('مثال: +9639'),

            Textarea::make('note')
              ->label('ملاحظات إضافية')
              ->placeholder('اكتب هنا أي ملاحظات أو تفاصيل متعلقة بالاشتراك...')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
