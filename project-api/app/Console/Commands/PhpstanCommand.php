<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PhpstanCommand extends Command
{
    protected $signature = 'phpstan';
    protected $description = 'Run PHPStan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Running PHPStan...');

        $output = null;
        $returnVar = null;

        exec('vendor/bin/phpstan', $output, $returnVar);

        foreach ($output as $line) {
            $this->line($line);
        }

        if ($returnVar !== 0) {
            $this->error('PHPStan failed. Please fix accordingly.');
            return 1;
        }

        $this->info('PHPStan completed successfully.');
        return 0;
    }
}
