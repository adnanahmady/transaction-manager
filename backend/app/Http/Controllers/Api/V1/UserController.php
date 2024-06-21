<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\AppServices\Users\GetService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Users\UsersCollection;

class UserController extends Controller
{
    public function index(GetService $service): UsersCollection
    {
        return new UsersCollection($service->getWithHighestTransactions());
    }
}
