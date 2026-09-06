<?php

namespace App\Filament\Resources\Notes\Schemas;

use App\Models\Worker;
use App\Models\Kadr;
use App\Models\Company;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;

class NoteForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('user_id')
          ->relationship('user', 'name')
          ->label('كاتب الملاحظة')
          ->default(fn() => auth()->id())
          ->disabled()
          ->dehydrated()
          ->required(),

        Select::make('notable_type')
          ->label('نوع الجهة المستهدفة')
          ->options([
            Worker::class  => 'عامل (Worker)',
            Kadr::class    => 'كادر (Kadr)',
            Company::class => 'شركة (Company)',
          ])
          ->reactive()
          ->afterStateUpdated(fn(callable $set) => $set('notable_id', null))
          ->required()
          ->placeholder('اختر النوع أولاً...')
          ->columnSpanFull(),

        Select::make('notable_id')
          ->label('اختر السجل المحدد')
          ->options(function (Get $get) {
            $type = $get('notable_type');

            if (!$type) {
              return [];
            }

            return match ($type) {
              Worker::class => Worker::query()
                ->get()
                ->mapWithKeys(fn($worker) => [$worker->id => "{$worker->full_name} ({$worker->phone_whatsapp})"])
                ->toArray(),

              Kadr::class => Kadr::query()
                ->get()
                ->mapWithKeys(fn($kadr) => [$kadr->id => "{$kadr->name} ({$kadr->phone})"])
                ->toArray(),

              Company::class => Company::query()
                ->get()
                ->mapWithKeys(fn($company) => [$company->id => $company->company_name])
                ->toArray(),

              default => [],
            };
          })
          ->searchable()
          ->preload()
          ->required()
          ->disabled(fn(Get $get) => !filled($get('notable_type')))
          ->placeholder(fn(Get $get) => filled($get('notable_type')) ? 'اختر السجل...' : 'اختر نوع الجهة أولاً...')
          ->columnSpanFull(),

        Textarea::make('notes')
          ->label('نص الملاحظة')
          ->rows(4)
          ->required()
          ->placeholder('اكتب تفاصيل الملاحظة هنا...')
          ->columnSpanFull(),
      ]);
  }
}
