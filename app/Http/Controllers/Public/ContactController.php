<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('public.contact.index', [
            'address' => Setting::get('alamat_kantor'),
            'mapsUrl' => Setting::get('maps_url'),
            'email' => Setting::get('email', config('site.email')),
            'whatsapp' => Setting::get('whatsapp', config('site.whatsapp')),
            'whatsappDisplay' => Setting::get('whatsapp_display', config('site.whatsapp_display')),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Pesan Anda telah terkirim. Terima kasih, kami akan segera menindaklanjuti.');
    }
}
