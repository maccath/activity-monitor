<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return View
     */
    public function index()
    {
        return view('dashboard/home');
    }

    /**
     * @return View
     */
    public function streams()
    {
        $streamServices = app()->tagged('streams');

        return view('dashboard/streams')
          ->with('streams', $streamServices);
    }
}
