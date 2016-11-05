<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
