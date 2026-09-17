<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function placeholder(string $title, string $message): View
    {
        return view('public.placeholder', ['pageTitle' => $title, 'message' => $message]);
    }
}
