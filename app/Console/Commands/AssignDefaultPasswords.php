<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Worker;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

#[Signature('app:assign-default-passwords')]
#[Description('Command description')]
class AssignDefaultPasswords extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:assign-default-passwords';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Assign a default hashed password (12345678) to workers and companies that do not have a password.';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $defaultPassword = Hash::make('12345678');

    $workersUpdated = Worker::whereNull('password')
      ->orWhere('password', '')
      ->update(['password' => $defaultPassword]);

    $companiesUpdated = Company::whereNull('password')
      ->orWhere('password', '')
      ->update(['password' => $defaultPassword]);

    $this->info("Successfully updated {$workersUpdated} workers and {$companiesUpdated} companies with the default password.");
  }
}
