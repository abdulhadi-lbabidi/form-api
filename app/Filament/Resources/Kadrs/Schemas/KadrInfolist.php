<?php

namespace App\Filament\Resources\Kadrs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use ZipArchive;

class KadrInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الكادر')
          ->description('المعلومات الأساسية وبيانات الاتصال والموقع ووسائل التواصل الخاصة بالكادر.')
          ->icon('heroicon-o-user')
          ->schema([

            Grid::make(3)->schema([
              TextEntry::make('name')
                ->label('الاسم الكامل (أو اللقب)')
                ->weight('bold'),

              TextEntry::make('first_name')
                ->label('الاسم الأول')
                ->placeholder('غير متوفر'),

              TextEntry::make('father_name')
                ->label('اسم الأب')
                ->placeholder('غير متوفر'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('last_name')
                ->label('اسم العائلة')
                ->placeholder('غير متوفر'),

              TextEntry::make('date_of_birth')
                ->label('تاريخ الميلاد')
                ->date('Y-m-d')
                ->placeholder('غير متوفر'),

              TextEntry::make('created_at')
                ->label('تاريخ الإنشاء')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A'),
            ]),

            Grid::make(2)->schema([
              TextEntry::make('phone')
                ->label('رقم الهاتف')
                ->icon('heroicon-m-phone')
                ->color('success')
                ->copyable()
                ->url(fn($record) => "tel:{$record->phone}"),

              TextEntry::make('email')
                ->label('البريد الإلكتروني')
                ->icon('heroicon-m-envelope')
                ->color('info')
                ->copyable()
                ->placeholder('لا يوجد'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('service_type')
                ->label('نوع الخدمة المقدمة')
                ->badge()
                ->color('success')
                ->placeholder('غير مسجل'),

              TextEntry::make('categories.name')
                ->label('التصنيفات')
                ->badge()
                ->color('primary')
                ->placeholder('لا توجد تصنيفات مسجلة'),

              TextEntry::make('has_team')
                ->label('هل لديه فريق عمل؟')
                ->formatStateUsing(fn($state) => $state ? 'نعم لديه فريق' : 'لا')
                ->badge()
                ->color(fn($state) => $state ? 'info' : 'gray'),

              TextEntry::make('number_of_person')
                ->label('عدد أفراد الفريق')
                ->placeholder('لا يوجد'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('city')
                ->label('المدينة')
                ->icon('heroicon-m-map-pin')
                ->color('primary'),

              TextEntry::make('residential_area')
                ->label('منطقة السكن / الحي')
                ->placeholder('غير محدد'),

              TextEntry::make('location.name')
                ->label('المنطقة الجغرافية')
                ->placeholder('غير محدد')
                ->icon('heroicon-m-map')
                ->badge()
                ->color('success'),


            ]),

            TextEntry::make('shop_address')
              ->label('عنوان المحل / العمل')
              ->placeholder('لا يوجد عنوان مسجل')
              ->columnSpanFull(),

            TextEntry::make('social_or_website_link')
              ->label('رابط الموقع أو التواصل الاجتماعي')
              ->icon('heroicon-m-link')
              ->url(fn($record) => $record->social_or_website_link)
              ->openUrlInNewTab()
              ->placeholder('لا يوجد رابط مسجل')
              ->columnSpanFull(),

            TextEntry::make('marketingSources.name')
              ->label('مصادر التعرف علينا')
              ->state(fn($record) => $record->marketingSources->map(fn($source) => $source->translated_name)->toArray())
              ->badge()
              ->color('warning')
              ->placeholder('لم يتم تحديد أي مصدر')
              ->columnSpanFull(),

            Section::make('المرفقات والملفات')
              ->description('الصور أو السيرة الذاتية (CV / Portfolio) الخاصة بالكادر.')
              ->headerActions([
                Action::make('download_all')
                  ->label('تحميل جميع الملفات (ZIP)')
                  ->icon('heroicon-m-arrow-down-tray')
                  ->color('primary')
                  ->visible(fn($record) => $record && $record->media()->exists())
                  ->action(function ($record) {
                    $mediaCollection = $record->getMedia('kadrs');

                    if ($mediaCollection->isEmpty()) {
                      return;
                    }

                    $zipFileName = 'kadr_' . $record->id . '_documents.zip';
                    $zipPath = storage_path('app/public/' . $zipFileName);

                    $zip = new ZipArchive;
                    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                      foreach ($mediaCollection as $media) {
                        if (file_exists($media->getPath())) {
                          $zip->addFile($media->getPath(), $media->file_name);
                        }
                      }
                      $zip->close();
                    }

                    return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
                  })
              ])
              ->schema([
                RepeatableEntry::make('media')
                  ->label('الملفات والمستندات المرفوعة')
                  ->state(fn($record) => $record->getMedia('kadrs'))
                  ->schema([
                    ImageEntry::make('file_name')
                      ->label('')
                      ->visible(fn($record) => $record && str_starts_with($record->mime_type, 'image/'))
                      ->state(fn($record) => $record?->getUrl())
                      ->square()
                      ->size(80)
                      ->hintAction(
                        Action::make('download_img')
                          ->label('تحميل')
                          ->icon('heroicon-m-arrow-down-tray')
                          ->action(fn($record) => response()->download($record->getPath(), $record->file_name))
                      ),

                    TextEntry::make('file_name')
                      ->label('')
                      ->icon('heroicon-o-document-text')
                      ->color('warning')
                      ->visible(fn($record) => $record && !str_starts_with($record->mime_type, 'image/'))
                      ->weight('bold')
                      ->hintAction(
                        Action::make('download_doc')
                          ->label('تحميل الملف')
                          ->icon('heroicon-m-arrow-down-tray')
                          ->action(fn($record) => response()->download($record->getPath(), $record->file_name))
                      ),
                  ])
                  ->grid(4)
                  ->columnSpanFull(),
              ]),

          ])->columnSpanFull(),
      ]);
  }
}
