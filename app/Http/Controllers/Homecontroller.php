<?php

namespace App\Http\Controllers;

use App\Models\DecisionModel;
use App\Models\Server;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\HTTPSConnector;
use App\Health\Cls\FTPConnector;
use App\Health\Cls\SSHConnector;
use App\Health\Factory\Decision;
use App\Health\Factory\HealthCheckFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
   public function index()
    {
        return view('home');
    }



public function serverTests(Request $request)
{
    try {
        $tests = DecisionModel::orderBy('created_at', 'desc')
            ->paginate(10);

        $tests->getCollection()->transform(function ($test) {
            return [
                'name'       => $test->name ?? 'N/A',
                'ip_address' => $test->ip_address ?? 'N/A',
                'status'     => $test->status ?? 'unknown',
                'message'    => $test->message ?? '',
                'timestamp'  => $test->created_at
                    ? $test->created_at->format('Y-m-d H:i:s')
                    : '-',
            ];
        });

        return response()->json([
            'data'         => $tests->items(),
            'current_page' => $tests->currentPage(),
            'last_page'    => $tests->lastPage(),
            'per_page'     => $tests->perPage(),
            'total'        => $tests->total(),
            'prev_page_url'=> $tests->previousPageUrl(),
            'next_page_url'=> $tests->nextPageUrl(),
        ]);

    } catch (\Throwable $e) {
        \Log::error('serverTests error: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}


    public function doDecision()
    {
        $result = Decision::makeDecision();

         return view('home');
    }
}
