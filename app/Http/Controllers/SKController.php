<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\SK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SKController extends Controller
{
    public function index(Request $request)
    {
        $query = SK::with(['division', 'creator']);
        
        // Filter berdasarkan role user
        if (auth()->check() && auth()->user()->isAnggotaDivisi()) {
            $query->where('division_id', auth()->user()->division_id);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%")
                  ->orWhereHas('division', function($div) use ($search) {
                      $div->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter divisi
        if ($request->filled('division')) {
            $query->where('division_id', $request->division);
        }

        // Filter tahun
        if ($request->filled('year')) {
            $query->whereYear('tanggal_terbit', $request->year);
        }

        $sks = $query->latest()->paginate(10);
        $divisions = Division::orderBy('nama')->get();
        $years = SK::selectRaw('YEAR(tanggal_terbit) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('sks.index', compact('sks', 'divisions', 'years'));
    }

    public function create()
    {
        $this->authorize('create', SK::class);
        
        $divisions = auth()->user()->isAdmin() 
            ? Division::orderBy('nama')->get()
            : collect([auth()->user()->division]);

        return view('sks.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', SK::class);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor' => 'required|string|max:100|unique:sks,nomor',
            'deskripsi' => 'nullable|string',
            'tanggal_terbit' => 'required|date',
            'division_id' => [
                'required',
                'exists:divisions,id',
                Rule::in(auth()->user()->isAdmin() 
                    ? Division::pluck('id')->toArray()
                    : [auth()->user()->division_id]
                )
            ],
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ], [
            'judul.required' => 'Judul SK harus diisi.',
            'nomor.required' => 'Nomor SK harus diisi.',
            'nomor.unique' => 'Nomor SK sudah ada, gunakan nomor lain.',
            'tanggal_terbit.required' => 'Tanggal terbit harus diisi.',
            'division_id.required' => 'Divisi harus dipilih.',
            'file.required' => 'File SK harus diunggah.',
            'file.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('sk', $fileName, 'public');

        SK::create([
            'judul' => $request->judul,
            'nomor' => $request->nomor,
            'deskripsi' => $request->deskripsi,
            'tanggal_terbit' => $request->tanggal_terbit,
            'division_id' => $request->division_id,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType(),
            'dibuat_oleh' => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SK berhasil ditambahkan!',
                'redirect' => route('sks.index')
            ]);
        }

        return redirect()->route('sks.index')->with('success', 'SK berhasil ditambahkan!');
    }

    public function show(SK $sk)
    {
        $this->authorize('view', $sk);
        
        return view('sks.show', compact('sk'));
    }

    public function edit(SK $sk)
    {
        $this->authorize('update', $sk);
        
        $divisions = auth()->user()->isAdmin() 
            ? Division::orderBy('nama')->get()
            : collect([auth()->user()->division]);

        return view('sks.edit', compact('sk', 'divisions'));
    }

    public function update(Request $request, SK $sk)
    {
        $this->authorize('update', $sk);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor' => ['required', 'string', 'max:100', Rule::unique('sks')->ignore($sk->id)],
            'deskripsi' => 'nullable|string',
            'tanggal_terbit' => 'required|date',
            'division_id' => [
                'required',
                'exists:divisions,id',
                Rule::in(auth()->user()->isAdmin() 
                    ? Division::pluck('id')->toArray()
                    : [auth()->user()->division_id]
                )
            ],
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'judul.required' => 'Judul SK harus diisi.',
            'nomor.required' => 'Nomor SK harus diisi.',
            'nomor.unique' => 'Nomor SK sudah ada, gunakan nomor lain.',
            'tanggal_terbit.required' => 'Tanggal terbit harus diisi.',
            'division_id.required' => 'Divisi harus dipilih.',
            'file.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $updateData = [
            'judul' => $request->judul,
            'nomor' => $request->nomor,
            'deskripsi' => $request->deskripsi,
            'tanggal_terbit' => $request->tanggal_terbit,
            'division_id' => $request->division_id,
        ];

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($sk->file_path);
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('sk', $fileName, 'public');

            $updateData = array_merge($updateData, [
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
            ]);
        }

        $sk->update($updateData);

        return redirect()->route('sks.index')->with('success', 'SK berhasil diperbarui!');
    }

    public function destroy(SK $sk)
    {
        $this->authorize('delete', $sk);

        // Delete file
        Storage::disk('public')->delete($sk->file_path);
        
        $sk->delete();

        return redirect()->route('sks.index')->with('success', 'SK berhasil dihapus!');
    }

    public function download(SK $sk)
    {
        $this->authorize('view', $sk);

        if (!Storage::disk('public')->exists($sk->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($sk->file_path, $sk->file_name);
    }

    public function preview(SK $sk)
    {
        $this->authorize('view', $sk);

        if (!$sk->isPdf()) {
            return redirect()->back()->with('error', 'Preview hanya tersedia untuk file PDF.');
        }

        if (!Storage::disk('public')->exists($sk->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return view('sks.preview', compact('sk'));
    }
}