<?php

namespace Behin\JobManager\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;

class RunJobCommand extends Command
{
    protected $signature = 'jobs:run {id}';
    protected $description = 'Run a pending job immediately';

    public function handle(): int
    {
        $id = $this->argument('id');
        $record = DB::table('jobs')->where('id', $id)->first();

        if (! $record) {
            $this->error("Job {$id} not found.");
            return self::FAILURE;
        }

        $payload = json_decode($record->payload, true);
        if (! isset($payload['data']['command'])) {
            $this->error('Unable to decode job payload.');
            return self::FAILURE;
        }

        $job = unserialize($payload['data']['command']);

        Bus::dispatchSync($job);

        DB::table('jobs')->where('id', $id)->delete();

        $this->info("Job {$id} executed.");
        return self::SUCCESS;
    }
}
