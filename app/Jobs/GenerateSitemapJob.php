<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $path = 'sitemap.xml';
        
        SitemapGenerator::create('http://127.0.0.1:8000')
            ->writeToFile(public_path($path));

        echo 'Sitemap generated successfully. \n';
    }
}
