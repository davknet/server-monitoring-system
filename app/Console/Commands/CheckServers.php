<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RequestTestController;
use Illuminate\Support\Facades\Log;

class CheckServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-servers';

    /**
     * The console command description.
     *
     * @var string
     */
     protected $description = 'Run health checks on all servers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // Log::info('Server check started at ' . now());
        $controller = new RequestTestController();
        $controller->runChecks();
        $this->info('Server health checks completed!');

    }
}
