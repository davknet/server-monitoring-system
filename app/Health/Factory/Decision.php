<?php

namespace App\Health\Factory;

use App\Health\Cls\ConectorTest;
use App\Models\DecisionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Handles decision making for server health.
 */
class Decision
{
    /**
     * Main entry point.
     */
    public static function makeDecision(): void
    {
        $decision = new self();
        $groupedTests = $decision->getLastChecksPerServer();

        foreach ($groupedTests as $serverId => $tests) {

            $first = $tests->first(); // take metadata from latest record

            if(count($tests) < 5) {
                Log::warning("Not enough tests for server ID $serverId. Skipping decision.");
                return ; 
            }

            $checker = new ConectorTest(
                $first->server_id,
                $first->server_name,
                $first->server_ip,
                $first->status
            );

            $result = $checker->make($tests);

            DecisionModel::create([
                'name'       => $first->server_name,
                'ip_address' => $first->server_ip,
                'server_id'  => $first->server_id,
                'status'     => $result['status'],
                'timestamp'  => now(),
            ]);
           // Optional: store or log result
            Log::info($result);
        }
    }

    /**
     * Get last 5 checks per server.
     */
    public function getLastChecksPerServer()
    {
        $tests = DB::table('server_request_test as t1')
            ->select('t1.*')
            ->whereRaw('(
                SELECT COUNT(*)
                FROM server_request_test as t2
                WHERE t2.server_id = t1.server_id
                AND t2.created_at >= t1.created_at
            ) <= 5')
            ->orderBy('t1.server_id')
            ->orderByDesc('t1.created_at')
            ->get();

        return $tests->groupBy('server_id');
    }
}
