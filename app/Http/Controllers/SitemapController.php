<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateSitemap;
use Spatie\Sitemap\Sitemap;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\Url;
use App\Jobs\GenerateSitemapJob;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    //

    public function show()
    {
        $sitemapPath = public_path('sitemap.xml');
        if (file_exists($sitemapPath)) {
            $sitemapContent = simplexml_load_file($sitemapPath);
            $urls = [];

            foreach ($sitemapContent->url as $url) {
                $urls[] = (string) $url->loc;
            }

            return view('sitemap', ['urls' => $urls]);
        } else {
            return response('Sitemap not found', 404);
        }
    }

    public function generate()
    {
        GenerateSitemapJob::dispatch();
        return response()->json(['message' => 'Sitemap generation job dispatched successfully.']);
    }
}
