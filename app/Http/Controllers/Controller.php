<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function isAuthorized($permission)
    {
        return Auth::check() && in_array($permission, Auth::user()->permissions ?? []);
    }
}

