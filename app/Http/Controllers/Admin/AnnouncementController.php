<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        return view('admin.announcements.index', [
            'announcements' => Announcement::latest('published_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(AnnouncementRequest $request): RedirectResponse
    {
        Announcement::create($this->payload($request));

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', ['announcement' => $announcement]);
    }

    public function update(AnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $announcement->update($this->payload($request));

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(AnnouncementRequest $request): array
    {
        return [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'published_at' => $request->input('published_at') ?? now(),
        ];
    }
}
