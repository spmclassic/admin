<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;

class InitController extends Controller
{
    use ResponseTrait;
    const PAGESIZE = 20;
}