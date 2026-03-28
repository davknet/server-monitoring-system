<?php
namespace App\Http\Controllers;

use  App\Models\Server ;
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


 public function update()
{
    // $protocols = Protocol::all();
    // $methods = Method::all();
    $servers = Server::latest()->get(); //  get all servers

    return view('update-server', compact( 'servers'));
}


}
