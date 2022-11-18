<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;

class ServiceController extends Controller
{
    public function getServices(): Collection
    {
        return DB::table('services')
            ->get();
    }
}
