<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function setEmail(Request $request) {

        \Session::put('emailN', $request->emailN);
        return redirect('/register');
    }
    public function index()
    {
        if(\Auth::check()) {
            return redirect('/plans');
        }
        else {
            return view('welcome');
        }
    }
}