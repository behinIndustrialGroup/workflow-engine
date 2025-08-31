<?php

namespace Behin\JobManager\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ListJobsCommand extends Command
{
    protected $signature = 'jobs:list';
    protected $description = 'Display a list of pending jobs';

    public function handle(): int
    {
        $jobs = DB::table('jobs')->orderBy('id')->get()->map(function ($job) {
            $payload = json_decode($job->payload, true);
            $job->name = $payload['displayName'] ?? ($payload['data']['commandName'] ?? '');
            return $job;
        });

        if ($jobs->isEmpty()) {
            $this->info('No jobs found.');
            return self::SUCCESS;
        }

        $rows = $jobs->map(function ($job) {
            return [
                'ID' => $job->id,
                'Queue' => $job->queue,
                'Job' => $job->name,
                'Attempts' => $job->attempts,
            ];
        });

        $this->table(['ID', 'Queue', 'Job', 'Attempts'], $rows);

        return self::SUCCESS;
    }
}
