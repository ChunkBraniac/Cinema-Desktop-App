<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    //

    public function showXml()
    {
        Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/movies'))
        ->add(Url::create('/about'))
        ->add(Url::create('/contact'))
        // Add more URLs as needed
        ->writeToFile(public_path('sitemap.xml'));

        return response()->file(public_path('sitemap.xml'));
    }

    public function showHtml()
    {
        $urls = [
            ['loc' => url('/'), 'title' => 'Home'],
            ['loc' => url('/movies'), 'title' => 'Movies'],
            ['loc' => url('/about'), 'title' => 'About'],
            ['loc' => url('/contact'), 'title' => 'Contact'],
        ];

        return view('sitemap', compact('urls'));
    }
}
