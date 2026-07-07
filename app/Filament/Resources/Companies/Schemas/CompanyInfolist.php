<?php

namespace App\Filament\Resources\Companies\Schemas;

use App\Models\ReferralCode;
use App\Models\Company;
use App\Models\Worker;
use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use ZipArchive;

class CompanyInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل سجل الشركة')
          ->description('المعلومات الأساسية وبيانات الاتصال والموقع الرئيسي للشركة.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('company_name')
                ->label('اسم الشركة')
                ->weight('bold'),

              TextEntry::make('city')
                ->label('المدينة / المحافظة')
                ->icon('heroicon-m-map-pin')
                ->color('primary'),

              TextEntry::make('business_type')
                ->label('نوع العمل')
                ->color('gray'),

              TextEntry::make('owner_name')
                ->label('اسم المالك')
                ->icon('heroicon-m-user'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('work_location')
                ->label('موقع العمل')
                ->icon('heroicon-m-map-pin')
                ->color('primary'),

              TextEntry::make('email')
                ->label('البريد الإلكتروني')
                ->icon('heroicon-m-envelope')
                ->color('info')
                ->copyable()
                ->copyMessage('تم نسخ البريد الإلكتروني')
                ->url(fn($record) => "mailto:{$record->email}"),

              TextEntry::make('phone_number')
                ->label('رقم الهاتف')
                ->icon('heroicon-m-phone')
                ->color('success')
                ->copyable()
                ->copyMessage('تم نسخ رقم الهاتف')
                ->url(fn($record) => "tel:{$record->phone_number}")
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: bold;']),
            ]),

            TextEntry::make('problems_faced')
              ->label('المشاكل التي تواجهها الشركة (إن وجدت)')
              ->placeholder('لا توجد مشاكل مسجلة أو تحديات تواجه سير العمل حالياً.')
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('التواريخ والنظام والإحالات')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(3)
          ->schema([

            TextEntry::make('code')
              ->label('رمز الشركة الفريد (سيرفر)')
              ->placeholder('لم يتم التوليد (غير موثقة)')
              ->fontFamily('mono')
              ->weight('bold')
              ->color('primary')
              ->icon('heroicon-m-qr-code')
              ->copyable()
              ->copyMessage('تم نسخ الرمز بنجاح'),

            IconEntry::make('is_verified')
              ->label('حالة التوثيق')
              ->boolean()
              ->trueIcon('heroicon-m-check-circle')
              ->falseIcon('heroicon-m-x-circle')
              ->trueColor('success')
              ->falseColor('danger'),

            TextEntry::make('created_at')
              ->label('تاريخ تسجيل الشركة')
              ->icon('heroicon-m-calendar')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

            TextEntry::make('referralCode.code')
              ->label('كود الإحالة الخاص بالشركة')
              ->placeholder('لا يوجد كود إحالة')
              ->color('success')
              ->icon('heroicon-m-gift')
              ->copyable(),

            TextEntry::make('form_referral_code')
              ->label('سجلت بكود إحالة رقم')
              ->placeholder('تسجيل مباشر (بدون كود)')
              ->badge()
              ->color('info'),

            TextEntry::make('marketingSources.name')
              ->label('مصادر التعرف علينا')
              ->state(fn($record) => $record->marketingSources->map(fn($source) => $source->translated_name)->toArray())
              ->badge()
              ->color('warning')
              ->placeholder('لم يتم تحديد أي مصدر'),


            TextEntry::make('invited_by')
              ->label('تمت الدعوة بواسطة')
              ->placeholder('لا يوجد داعٍ (تسجيل مباشر)')
              ->icon('heroicon-m-user-plus')
              ->weight('bold')
              ->color('warning')
              ->state(function ($record) {
                if (empty($record->form_referral_code)) {
                  return null;
                }

                $referral = ReferralCode::with('referralable')->where('code', $record->form_referral_code)->first();

                if ($referral && $referral->referralable) {
                  $owner = $referral->referralable;

                  if ($owner instanceof Company) {
                    return $owner->company_name . ' (شركة)';
                  }

                  if ($owner instanceof Worker) {
                    return $owner->first_name . ' ' . $owner->last_name . ' (عامل)';
                  }
                }

                return $record->form_referral_code;
              }),

          ])->columnSpanFull(),



        // Section::make('الوثائق والمرفقات الرسمية')
        //   ->icon('heroicon-o-paper-clip')
        //   ->description('الأوراق الثبوتية والصور المرفوعة الخاصة بالشركة.')
        //   ->schema([
        //     SpatieMediaLibraryImageEntry::make('image')
        //       ->label('الملفات المستندة')
        //       ->collection('companies')
        //       ->square()
        //       ->columnSpanFull()
        //       ->hintAction(
        //         Action::make('download_document')
        //           ->label('تحميل الملفات')
        //           ->icon('heroicon-m-arrow-down-tray')
        //           ->color('primary')
        //           ->visible(fn($record) => $record && $record->hasMedia('companies'))
        //           ->action(function ($record) {
        //             $media = $record->getFirstMedia('companies');
        //             if ($media) {
        //               return response()->download($media->getPath(), $media->file_name);
        //             }
        //           })
        //       )
        //   ])->columnSpanFull(),

        Section::make('الوثائق والمرفقات الرسمية')
          ->icon('heroicon-o-paper-clip')
          ->description('الأوراق الثبوتية والصور المرفوعة الخاصة بالشركة.')
          ->headerActions([
            Action::make('download_all')
              ->label('تحميل جميع الملفات (ZIP)')
              ->icon('heroicon-m-arrow-down-tray')
              ->color('primary')
              ->visible(fn($record) => $record && $record->media()->exists())
              ->action(function ($record) {
                $mediaCollection = $record->getMedia('companies');

                if ($mediaCollection->isEmpty()) {
                  return;
                }

                $zipFileName = 'company_' . $record->id . '_documents.zip';
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
          ])->columnSpanFull(),
      ]);
  }
}
