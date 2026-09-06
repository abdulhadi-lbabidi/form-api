<?php

namespace App\Filament\Resources\Notes\Schemas;

use App\Filament\Resources\Companies\CompanyResource;
use App\Filament\Resources\Kadrs\KadrResource;
use App\Filament\Resources\Workers\WorkerResource;
use App\Models\Company;
use App\Models\Kadr;
use App\Models\Worker;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NoteInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الملاحظة')
          ->description('معلومات الملاحظة والجهة المرتبطة بها والشخص المسؤول عنها.')
          ->icon('heroicon-o-chat-bubble-bottom-center-text')
          ->headerActions([
            Action::make('go_to_target')
              ->label('الذهاب إلى السجل المرتبط')
              ->icon('heroicon-m-arrow-top-right-on-square')
              ->color('success')
              ->url(function ($record) {
                return match ($record->notable_type) {
                  Company::class => CompanyResource::getUrl('view', ['record' => $record->notable_id]),
                  Kadr::class    => KadrResource::getUrl('view', ['record' => $record->notable_id]),
                  Worker::class  => WorkerResource::getUrl('view', ['record' => $record->notable_id]),
                  default                    => '#',
                };
              })
              ->openUrlInNewTab(),
          ])
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('user.name')
                ->label('كاتب الملاحظة')
                ->icon('heroicon-m-user')
                ->badge()
                ->color('info'),

              TextEntry::make('created_at')
                ->label('تاريخ الإنشاء')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A'),
            ]),

            TextEntry::make('notable_type')
              ->label('نوع الجهة المرتبطة')
              ->formatStateUsing(fn($state) => match ($state) {
                Worker::class => 'عامل (Worker)',
                Kadr::class => 'كادر (Kadr)',
                Company::class => 'شركة (Company)',
                default => class_basename($state),
              })
              ->badge()
              ->color('warning'),

            TextEntry::make('notes')
              ->label('نص الملاحظة')
              ->columnSpanFull()
              ->weight('bold'),
          ])
          ->columnSpanFull(),
      ]);
  }
}