<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\WorkerService;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
  public function __construct(
    private WorkerService $workerService
  ) {}
}
