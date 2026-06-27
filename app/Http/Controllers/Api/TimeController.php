<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\TimeService;
use Illuminate\Http\Request;

class TimeController extends Controller
{
  public function __construct(
    private TimeService $timeService
  ) {}
}
