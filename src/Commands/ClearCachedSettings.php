<?php

namespace Laravel\Settings\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClearCachedSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached settings from file.';

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
     * @return void
     */
    public function handle(Filesystem $fs)
    {
        $this->warn('Clearing cached settings...');
        $fs->delete(config('settings.cache_path'));
        $this->info('Done!');
    }
}
