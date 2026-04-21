<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Main extends Controller
{

    public function redirect()
    {
        return redirect('/');
    }

    public function registerOptions()
    {
        return view('auth.register-options');
    }

}
