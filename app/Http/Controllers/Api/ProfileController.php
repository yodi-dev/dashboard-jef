<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhotographerProfileResource;
use App\Models\PhotographerProfile;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = PhotographerProfile::current();

        return (new PhotographerProfileResource($profile))->response()->setStatusCode(200);
    }
}
