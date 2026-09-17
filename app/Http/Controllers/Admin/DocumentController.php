<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::with('uploader')->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        return view('admin.documents.index', [
            'documents' => $query->paginate(15),
            'activeCategory' => $request->input('category'),
        ]);
    }

    public function store(DocumentRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $path = $file->store('documents', 'local');

        Document::create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        Storage::disk('local')->delete($document->file_path);
        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen dihapus.');
    }

    public function download(Document $document): StreamedResponse
    {
        $disk = Storage::disk('local');

        abort_if(! $disk->exists($document->file_path), 404);

        $safeName = Str::slug(pathinfo($document->file_name, PATHINFO_FILENAME))
            .'.'
            .pathinfo($document->file_name, PATHINFO_EXTENSION);

        return $disk->download($document->file_path, $safeName);
    }
}
