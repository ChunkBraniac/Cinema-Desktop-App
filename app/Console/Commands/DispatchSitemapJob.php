<?php

namespace App\Console\Commands;

use App\Jobs\GenerateSitemapJob;
use Illuminate\Console\Command;

class DispatchSitemapJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        GenerateSitemapJob::dispatch();
        $this->info('Sitemap job dispatched successfully.');

    }
}
