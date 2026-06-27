<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
  public function __construct(
    private CompanyService $companyService
  ) {}
}