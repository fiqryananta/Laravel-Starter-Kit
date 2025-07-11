<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    
        $this->data['title'] = 'Dashboard - ' . env('APP_NAME');

        return view('backend/dashboard/index', $this->data);

    }
}
