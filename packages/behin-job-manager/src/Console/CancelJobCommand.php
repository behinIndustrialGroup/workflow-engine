<?php

namespace Behin\JobManager\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelJobCommand extends Command
{
    protected $signature = 'jobs:cancel {id}';
    protected $description = 'Cancel a pending job';

    public function handle(): int
    {
        $id = $this->argument('id');
        $deleted = DB::table('jobs')->where('id', $id)->delete();

        if ($deleted) {
            $this->info("Job {$id} cancelled.");
        } else {
            $this->error("Job {$id} not found.");
        }

        return self::SUCCESS;
    }
}
