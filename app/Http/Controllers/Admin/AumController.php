<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AumRequest;
use App\Models\Aum;
use App\Services\ImageOptimizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AumController extends Controller
{
    public function index(): View
    {
        return view('admin.aum.index', [
            'aumList' => Aum::withTrashed()->orderBy('type')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.aum.create');
    }

    public function store(AumRequest $request): RedirectResponse
    {
        Aum::create($this->payload($request));

        return redirect()->route('admin.aum.index')->with('success', 'AUM berhasil ditambahkan.');
    }

    public function edit(Aum $aum): View
    {
        return view('admin.aum.edit', ['aum' => $aum]);
    }

    public function update(AumRequest $request, Aum $aum): RedirectResponse
    {
        $aum->update($this->payload($request));

        return redirect()->route('admin.aum.index')->with('success', 'Data AUM berhasil diperbarui.');
    }

    public function destroy(Aum $aum): RedirectResponse
    {
        $aum->delete();

        return redirect()->route('admin.aum.index')->with('success', 'AUM dihapus (soft delete).');
    }

    public function restore(Aum $aum): RedirectResponse
    {
        $aum->restore();

        return redirect()->route('admin.aum.index')->with('success', 'AUM dikembalikan.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(AumRequest $request): array
    {
        $data = [
            'type' => $request->input('type'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
            'maps_url' => $request->input('maps_url'),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = ImageOptimizer::optimize($request->file('photo'), 'aum', 800);
        }

        return $data;
    }
}
