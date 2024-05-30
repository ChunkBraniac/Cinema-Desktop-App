<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateSitemap;
use Spatie\Sitemap\Sitemap;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

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
}
