<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Aum;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AumController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();
        $validType = in_array($type, Aum::TYPES, true) ? $type : null;

        $query = Aum::query();

        if ($validType) {
            $query->where('type', $validType);
        }

        return view('public.aum.index', [
            'aums' => $query->latest('name')->paginate(12),
            'types' => Aum::TYPES,
            'activeType' => $validType,
        ]);
    }

    public function show(string $id): View
    {
        $aum = Aum::findOrFail($id);

        return view('public.aum.show', [
            'aum' => $aum,
            'others' => Aum::whereKeyNot($aum->id)->where('type', $aum->type)->latest('name')->take(3)->get(),
        ]);
    }
}
