<?php

namespace Laravel\Settings\Commands;

use Laravel\Settings\Settings;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CacheSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache settings from database into a file.';

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
     * @param Settings $settings
     * @param Filesystem $fs
     *
     * @return void
     */
    public function handle(Settings $settings, Filesystem $fs)
    {
        $this->warn('Caching saved settings...');
        $fs->put(
            config('settings.cache_path'),
            '<?php return ' . var_export($settings->all(), true) . ';'
        );
        $this->info('Done!');
    }
}
