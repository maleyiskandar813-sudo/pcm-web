<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profil(): View
{
    return view('public.profile.profil', [
        'sejarah' => Setting::get('profil_sejarah'),
        'visiMisi' => Setting::get('profil_visi_misi'),
        'struktur' => $this->decodeList(Setting::get('struktur_organisasi')),
    ]);
}

public function visiMisi(): View
{
    return view('public.profile.visi-misi', [
        'visiMisi' => Setting::get('profil_visi_misi'),
    ]);
}

public function sejarah(): View
{
    return view('public.profile.sejarah', [
        'sejarah' => Setting::get('profil_sejarah'),
    ]);
}
public function struktur(): View
{
    return view('public.profile.struktur', [
        'struktur' => $this->decodeList(Setting::get('struktur_organisasi')),
    ]);
}
    public function majelis(): View
    {
        return view('public.profile.majelis', [
            'majelis' => $this->decodeList(Setting::get('majelis_lembaga')),
        ]);
    }

    private function decodeList(?string $json): array
    {
        if (! $json) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }
}
