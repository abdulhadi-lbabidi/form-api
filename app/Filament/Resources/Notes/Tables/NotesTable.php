<?php

namespace App\Filament\Resources\Notes\Tables;

use App\Filament\Resources\Companies\CompanyResource;
use App\Filament\Resources\Kadrs\KadrResource;
use App\Filament\Resources\Workers\WorkerResource;
use App\Models\Company;
use App\Models\Kadr;
use App\Models\Worker;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NotesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->modifyQueryUsing(function (Builder $query) {
        if (!auth()->user()->hasRole('super_admin')) {
          $query->where('user_id', auth()->id());
        }
      })
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('user.name')
          ->label('كاتب الملاحظة')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('notes')
          ->label('نص الملاحظة')
          ->limit(50)
          ->searchable(),

        TextColumn::make('notable_type')
          ->label('نوع الجهة المرتبطة')
          ->formatStateUsing(fn($state) => match ($state) {
            Worker::class => 'عامل',
            Kadr::class => 'كادر',
            Company::class => 'شركة',
            default => class_basename($state),
          })
          ->badge()
          ->color(fn($state) => match ($state) {
            Worker::class => 'info',
            Kadr::class => 'success',
            Company::class => 'warning',
            default => 'gray',  
          })
          ->sortable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        Action::make('go_to_target')
          ->label('الذهاب إلى')
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

        ViewAction::make(),
        EditAction::make(),
      ])
      ->headerActions([])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
