<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
  public function __construct(
    private SubscriptionService $subscriptionService
  ) {}
}
