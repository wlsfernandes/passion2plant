<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('frontend.home');
  }

  public function pulpitFellows()
  {
    return view('frontend.pulpit-fellows.index');
  }
}
