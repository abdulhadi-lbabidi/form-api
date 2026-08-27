<?php

namespace App\Filament\Resources\ApplyJobs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplyJobInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('worker.full_name')
          ->label('اسم العامل'),
        TextEntry::make('worker.phone_whatsapp')
          ->label('واتساب العامل'),
        TextEntry::make('jobable_type')
          ->label('نوع الوظيفة'),
        TextEntry::make('jobable_id')
          ->numeric()
          ->label('معرف الوظيفة'),
        TextEntry::make('status')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'accepted' => 'success',
            'rejected' => 'danger',
            default => 'gray',
          })
          ->label('الحالة'),
        TextEntry::make('notes')
          ->placeholder('-')
          ->columnSpanFull()
          ->label('ملاحظات'),
        TextEntry::make('created_at')
          ->dateTime()
          ->label('تاريخ التقديم'),
        TextEntry::make('updated_at')
          ->dateTime()
          ->label('آخر تحديث'),
      ]);
  }
}
