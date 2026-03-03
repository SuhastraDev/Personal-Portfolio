<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->orderBy('order')->get();

        return view('pages.services.index', compact('services'));
    }
}
