<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $posts = Post::published()->latest()->get(['slug', 'updated_at']);

        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('profil'), 'priority' => '0.8'],
            ['loc' => route('majelis'), 'priority' => '0.8'],
            ['loc' => route('berita.index'), 'priority' => '0.9'],
            ['loc' => route('aum.index'), 'priority' => '0.8'],
            ['loc' => route('agenda.index'), 'priority' => '0.8'],
            ['loc' => route('kontak'), 'priority' => '0.7'],
        ];

        $content = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $content .= "  <url>\n    <loc>{$url['loc']}</loc>\n    <priority>{$url['priority']}</priority>\n  </url>\n";
        }

        foreach ($posts as $post) {
            $content .= "  <url>\n    <loc>".route('berita.show', $post->slug)."</loc>\n    <lastmod>{$post->updated_at->toAtomString()}</lastmod>\n    <priority>0.6</priority>\n  </url>\n";
        }

        $content .= '</urlset>';

        return response($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /login\n";
        $content .= "\n";
        $content .= 'Sitemap: '.url('/sitemap.xml')."\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
