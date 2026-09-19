<?php

namespace App\Filament\Resources\CompanyNeeds\RelationManagers;

use App\Filament\Resources\Workers\WorkerResource;
use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkersRelationManager extends RelationManager
{
  protected static string $relationship = 'workers';

  protected static ?string $title = 'العمال المرتبطين وحالتهم';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('full_name')
      ->columns([
        TextColumn::make('full_name')
          ->label('اسم العامل')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('primary_profession')
          ->label('المهنة الأساسية')
          ->badge()
          ->color('warning'),

        TextColumn::make('phone_whatsapp')
          ->label('واتساب')
          ->icon('heroicon-m-phone'),

        TextColumn::make('pivot.delegate.user.name')
          ->label('المندوب المضيف')
          ->placeholder('غير محدد')
          ->badge()
          ->color('info'),

        TextColumn::make('pivot.status')
          ->label('الحالة الحالية')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'hired' => 'success',
            'rejected' => 'danger',
            default => 'gray',
          })
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'pending' => 'قيد الانتظار',
            'hired' => 'تم التوظيف',
            'rejected' => 'مرفوض',
            default => $state,
          }),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        AttachAction::make()
          ->label('ربط عمال بالاحتياج')
          ->preloadRecordSelect(),
      ])
      ->recordActions([
        ViewAction::make('view_worker')
          ->label('عرض العامل')
          ->icon('heroicon-m-eye')
          ->color('gray')
          ->url(fn($record): string => WorkerResource::getUrl('view', ['record' => $record]))
          ->openUrlInNewTab(),

        // زر موحد لتغيير الحالة يمنع أخطاء الإدخال
        Action::make('change_status')
          ->label('تغيير الحالة')
          ->icon('heroicon-m-arrow-path-rounded-square')
          ->color('info')
          ->form([
            Select::make('status')
              ->label('الحالة الجديدة')
              ->options([
                'pending' => 'قيد الانتظار',
                'hired' => 'تم التوظيف',
                'rejected' => 'مرفوض',
              ])
              ->default(fn($record) => $record->pivot->status)
              ->required()
              ->native(false), // تعرض قائمة منسدلة أنيق ومريحة للـ UI
          ])
          ->action(function ($record, array $data): void {
            // تحديث جدول الـ Pivot المرتبط بالعلاقة
            $this->getOwnerRecord()->workers()->updateExistingPivot($record->id, [
              'status' => $data['status'],
            ]);

            // إرسال إشعار نجاح واضح للمستخدم
            Notification::make()
              ->title('تم تحديث حالة العامل بنجاح')
              ->success()
              ->send();
          }),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DetachBulkAction::make(),
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
