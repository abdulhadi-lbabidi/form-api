<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CompaniesTable
{
  public static function configure(Table $table): Table
  {

    $user = Auth::user();
    $isDelegate = $user && $user->hasRole('delegate');

    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        IconColumn::make('is_verified')
          ->label('التوثيق')
          ->boolean()
          ->trueIcon('heroicon-m-check-circle')
          ->falseIcon('heroicon-m-x-circle')
          ->trueColor('success')
          ->falseColor('danger')
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('code')
          ->label('رمز الشركة')
          ->searchable()
          ->sortable()
          ->placeholder('غير موثق بعد')
          ->weight('bold')
          ->fontFamily('mono')
          ->color('primary')
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),


        TextColumn::make('company_status')
          ->label('الحالة')
          ->badge()
          ->sortable()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'new_lead'           => 'شركة جديدة',
            'contacted'           => 'تم التواصل',
            'active_opening'     => 'طلب شاغر نشط',
            'sourcing_matching'  => 'جاري ترشيح الكوادر',
            'interviews_underway' => 'في مرحلة المقابلات / الفحص',
            'order_fulfilled'    => 'تم تلبية الطلب بنجاح',
            'pending_commission' => 'بانتظار تحصيل العمولة',
            'inactive'            => 'غير نشط',
            'blocked'            => 'محظور',
            default               => $state,
          })
          ->color(fn(string $state): string => match ($state) {
            'new_lead'            => 'gray',
            'contacted'           => 'info',
            'active_opening'      => 'warning',
            'sourcing_matching', 'interviews_underway' => 'purple',
            'order_fulfilled'     => 'success',
            'pending_commission'  => 'success',
            'inactive', 'blocked' => 'danger',
            default               => 'gray',
          })
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),


        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->searchable()
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;'])
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

          TextColumn::make('company_name')
            ->label('اسم الشركة')
            ->searchable()
            ->sortable()
            ->weight('bold'),

        TextColumn::make('owner_name')
          ->label('المالك')
          ->placeholder('لا يوجد')
          ->searchable()
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('contact_person_name')
          ->label(' المسؤول عن التواصل')
          ->placeholder('لا يوجد')
          ->searchable()
          ->sortable()
          ->weight('bold')
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),


        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->color('primary')
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('business_type')
          ->label('نوع العمل')
          ->searchable()
          ->toggleable()
          ->badge()
          ->color('gray')
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),



        TextColumn::make('work_location')
          ->label('الموقع')
          ->searchable()
          ->color('primary')
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('email')
          ->label('البريد الإلكتروني')
          ->searchable()
          ->placeholder('لا يوجد')
          ->copyable()
          ->copyMessage('تم نسخ البريد الإلكتروني')
          ->url(fn($record) => "mailto:{$record->email}")
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('phone_number')
          ->label('رقم الهاتف')
          ->searchable()
          ->icon('heroicon-m-phone')
          ->copyable()
          ->copyMessage('تم نسخ رقم الهاتف')
          ->url(fn($record) => "tel:{$record->phone_number}")
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;'])
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('form_referral_code')
          ->label('كود الإحالة المُستخدَم')
          ->searchable()
          ->placeholder('لا يوجد')
          ->toggleable(isToggledHiddenByDefault: true)
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('creator.name')
          ->label('أُضيف بواسطة')
          ->sortable()
          ->searchable()
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),

        TextColumn::make('editor.name')
          ->label('عُدل بواسطة')
          ->sortable()
          ->searchable()
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),


      ])
      ->filters([
        SelectFilter::make('company_status')
          ->label('حالة الشركة')
          ->placeholder('كل الحالات')
          ->multiple()
          ->searchable()
          ->options([
            'new_lead'            => 'شركة جديدة',
            'contacted'           => 'تم التواصل',
            'active_opening'      => 'طلب شاغر نشط',
            'sourcing_matching'   => 'جاري ترشيح الكوادر',
            'interviews_underway' => 'في مرحلة المقابلات / الفحص',
            'order_fulfilled'     => 'تم تلبية الطلب بنجاح',
            'pending_commission'  => 'بانتظار تحصيل العمولة',
            'inactive'            => 'غير نشط',
            'blocked'             => 'محظور',
          ])
          ->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),


      ])
      ->recordActions([
        // ViewAction::make(),
        // EditAction::make(),
        ViewAction::make()->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),
        EditAction::make()->visible(fn($livewire) => !$isDelegate || $livewire->activeTab === 'my_companies'),
      ])
      ->headerActions([])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),

        ]),
      ]);
  }
}