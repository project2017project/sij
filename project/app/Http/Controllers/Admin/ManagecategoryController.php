<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ManagecategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

   
    //*** GET Request
    public function index()
    {
        return view('admin.managecat.index');
    }

}