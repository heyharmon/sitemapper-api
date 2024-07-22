<?php

namespace DDD\App\Console\Commands;

use DDD\Domain\Users\User;
use Illuminate\Console\Command;

class CountUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count total number of users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = User::count();

        $this->info('Total users: '.$count);
    }
}
