<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('public.home', [
            'namaCabang' => Setting::get('nama_cabang', 'Pimpinan Cabang Muhammadiyah Pujon'),
            'taglines' => [
                'Hidup-hidupilah Muhammadiyah, dan jangan mencari hidup di Muhammadiyah.',
                'Cahaya Islam Berkemajuan — Membangun Umat, Menebar Kebaikan.',
                'Mencerahkan Semesta, Memajukan Bangsa.',
                "Dakwah Amar Ma'ruf Nahi Munkar.",
                'Fastabiqul Khairat',
            ],
            'sambutan' => Setting::get('sambutan_ketua'),
            'latestPosts' => Post::published()->with('category')->latest('published_at')->take(6)->get(),
        ]);
    }
}
