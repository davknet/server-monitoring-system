<?php
namespace App\Http\Controllers;

use App\Models\Protocol;
use App\Models\Method;
use Illuminate\Http\Request;




class CreateServerController extends Controller
{
    public function index()
    {
          $protocols = Protocol::where('is_active', 1)->get();
          $methods  = Method::all();

        return view('create-server', compact('protocols', 'methods'));
    }

}
