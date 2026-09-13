<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupMail extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(
    public string $backupPath
  ) {}

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'KadrX Database Backup',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'emails.database-backup',
    );
  }

  /**
   * @return array<int, Attachment>
   */
  public function attachments(): array
  {
    return [
      Attachment::fromStorageDisk(
        'local',
        $this->backupPath
      )->as(
        basename($this->backupPath)
      )->withMime(
        'application/zip'
      ),
    ];
  }
}
