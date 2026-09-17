<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Announcement;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        return view('public.agenda.index', [
            'upcoming' => Agenda::where('starts_at', '>=', now())->orderBy('starts_at')->paginate(10),
            'past' => Agenda::where('starts_at', '<', now())->latest('starts_at')->take(5)->get(),
            'announcements' => Announcement::published()->latest('published_at')->take(5)->get(),
        ]);
    }
}
