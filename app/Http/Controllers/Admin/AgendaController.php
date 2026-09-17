<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgendaRequest;
use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        return view('admin.agenda.index', [
            'agenda' => Agenda::latest('starts_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.agenda.create');
    }

    public function store(AgendaRequest $request): RedirectResponse
    {
        Agenda::create($this->payload($request));

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda): View
    {
        return view('admin.agenda.edit', ['agenda' => $agenda]);
    }

    public function update(AgendaRequest $request, Agenda $agenda): RedirectResponse
    {
        $agenda->update($this->payload($request));

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(AgendaRequest $request): array
    {
        return [
            'title' => $request->input('title'),
            'starts_at' => $request->input('starts_at'),
            'ends_at' => $request->input('ends_at'),
            'location' => $request->input('location'),
            'description' => $request->input('description'),
        ];
    }
}
