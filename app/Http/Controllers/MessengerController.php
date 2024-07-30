<?php

namespace App\Http\Controllers;

use view;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function index()
    {
        return view('messenger.index');
    }
}
