<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('معلومات المستخدم')
          ->description('تفاصيل الحساب الشخصية والبيانات الأساسية')
          ->icon('heroicon-o-user')
          ->schema([
            Grid::make([
              'default' => 1,
              'sm' => 2,
              'lg' => 3,
            ])
              ->schema([
                TextEntry::make('name')
                  ->label('الاسم كاملاً')
                  ->icon('heroicon-m-user')
                  ->weight('bold')
                  ->copyable(),

                TextEntry::make('email')
                  ->label('البريد الإلكتروني')
                  ->icon('heroicon-m-envelope')
                  ->color('primary')
                  ->copyable(),

                TextEntry::make('roles.name')
                  ->label('الدور الأساسي')
                  ->icon('heroicon-m-shield-check')
                  ->badge()
                  ->color('success')
                  ->placeholder('بدون دور'),

                TextEntry::make('created_at')
                  ->label('تاريخ التسجيل')
                  ->icon('heroicon-m-calendar')
                  ->dateTime('Y-m-d h:i A')
                  ->placeholder('-'),
              ]),
          ])
          ->columnSpanFull(),

        Section::make('الصلاحيات الممنوحة للنظام')
          ->description('قائمة الصلاحيات التفصيلية المرتبطة بأدوار هذا المستخدم')
          ->icon('heroicon-o-lock-closed')
          ->schema([
            TextEntry::make('roles.permissions.name')
              ->label('')
              ->badge()
              ->color('info')
              ->separator(', ')
              ->listWithLineBreaks(false)
              ->bulleted(false)
              ->placeholder('لا توجد صلاحيات مخصصة'),
          ])
          ->columnSpanFull(),

      ]);
  }
}
