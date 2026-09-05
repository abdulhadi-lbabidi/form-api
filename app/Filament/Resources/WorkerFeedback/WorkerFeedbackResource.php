<?php

namespace App\Filament\Resources\WorkerFeedback;

use App\Filament\Resources\WorkerFeedback\Pages\CreateWorkerFeedback;
use App\Filament\Resources\WorkerFeedback\Pages\EditWorkerFeedback;
use App\Filament\Resources\WorkerFeedback\Pages\ListWorkerFeedback;
use App\Filament\Resources\WorkerFeedback\Pages\ViewWorkerFeedback;
use App\Filament\Resources\WorkerFeedback\Schemas\WorkerFeedbackForm;
use App\Filament\Resources\WorkerFeedback\Schemas\WorkerFeedbackInfolist;
use App\Filament\Resources\WorkerFeedback\Tables\WorkerFeedbackTable;
use App\Models\WorkerFeedback;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkerFeedbackResource extends Resource
{
  protected static ?string $model = WorkerFeedback::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;
  protected static ?string $navigationLabel = 'تقييمات العمال';
  protected static ?string $modelLabel = 'تقييم عامل';
  protected static ?int $navigationSort = 2;

  protected static ?string $pluralModelLabel = 'تقييمات العمال';
  protected static UnitEnum|string|null $navigationGroup = 'المراجعات';

  protected static ?string $recordTitleAttribute = 'WorkerFeedback';

  public static function form(Schema $schema): Schema
  {
    return WorkerFeedbackForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return WorkerFeedbackInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return WorkerFeedbackTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListWorkerFeedback::route('/'),
      'create' => CreateWorkerFeedback::route('/create'),
      'view' => ViewWorkerFeedback::route('/{record}'),
      'edit' => EditWorkerFeedback::route('/{record}/edit'),
    ];
  }
}
