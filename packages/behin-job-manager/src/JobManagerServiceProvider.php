<?php

namespace Behin\JobManager;

use Illuminate\Support\ServiceProvider;

class JobManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ListJobsCommand::class,
                Console\CancelJobCommand::class,
                Console\RunJobCommand::class,
            ]);
        }
    }
}
