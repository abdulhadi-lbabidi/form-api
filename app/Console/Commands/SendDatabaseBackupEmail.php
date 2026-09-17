<?php

namespace App\Console\Commands;

use App\Mail\DatabaseBackupMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendDatabaseBackupEmail extends Command
{
  protected $signature = 'backup:send-email';

  protected $description = 'Create database backup, send it by email, then delete it';

  public function handle(): int
  {
    $this->info('Creating database backup...');

    // Create backup
    $exitCode = Artisan::call('backup:run', [
      '--only-db' => true,
    ]);

    if ($exitCode !== 0) {
      $this->error('Database backup failed.');

      return self::FAILURE;
    }

    $this->info('Database backup created successfully.');

    // Find latest ZIP backup
    $files = Storage::disk('local')->allFiles();

    $backupFiles = collect($files)
      ->filter(fn(string $file) => str_ends_with(strtolower($file), '.zip'))
      ->sortByDesc(
        fn(string $file) => Storage::disk('local')->lastModified($file)
      )
      ->values();

    if ($backupFiles->isEmpty()) {
      $this->error('No backup ZIP file was found.');

      return self::FAILURE;
    }

    $latestBackup = $backupFiles->first();

    $this->info("Latest backup: {$latestBackup}");

    try {
      // Send email with attachment
      // Mail::to('abdalhadilbabidi@gmail.com')
      Mail::to('management@kadrx.com')
        ->send(new DatabaseBackupMail($latestBackup));

      $this->info('Backup email sent successfully.');

      // Delete backup after successful email
      Storage::disk('local')->delete($latestBackup);

      $this->info('Backup file deleted successfully.');

      return self::SUCCESS;
    } catch (\Throwable $e) {
      $this->error('Email sending failed.');
      $this->error($e->getMessage());

      // Keep backup if email failed
      return self::FAILURE;
    }
  }
}
