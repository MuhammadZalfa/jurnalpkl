<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\JournalImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    // Fungsi store sudah ada sebelumnya...
    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'day_number' => 'required|integer|min:1',
        'job_name' => 'required|string|max:255',
        'activity' => 'required|string|max:2000',
        'obstacle' => 'nullable|string|max:1000',
        'documentation' => 'nullable|array',
        'documentation.*' => 'image|mimes:jpeg,png,jpg|max:5120',
    ]);

    // Buat jurnal baru
    $journal = Journal::create([
        'user_id' => Auth::id(),
        'date' => $request->date,
        'day_number' => $request->day_number,
        'job_name' => $request->job_name,
        'activity' => $request->activity,
        'obstacle' => $request->obstacle,
        'status' => 'pending',
    ]);

    // Simpan gambar dokumentasi jika ada
    if ($request->hasFile('documentation')) {
        foreach ($request->file('documentation') as $file) {
            $path = $file->store('foto_jurnal', 'public');
            JournalImage::create([
                'journal_id' => $journal->id,
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('siswa.riwayat')
        ->with('success', 'Jurnal berhasil dibuat dan menunggu persetujuan.');
}
    public function index(Request $request)
    {
        $query = Journal::where('user_id', Auth::id());
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        
        $journals = $query->orderBy('date', 'desc')->paginate(10);
        
        return view('siswa.historyJurnal', compact('journals'));
    }
    
    public function edit($id)
    {
        $journal = Journal::with('images')->findOrFail($id);
        // Pastikan jurnal milik siswa yang sedang login
        if ($journal->user_id !== Auth::id()) {
            abort(403);
        }
        return view('siswa.editJurnal', compact('journal'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'day_number' => 'required|integer|min:1',
            'job_name' => 'required|string|max:255',
            'activity' => 'required|string|max:2000',
            'obstacle' => 'nullable|string|max:1000',
            'documentation' => 'nullable|array',
            'documentation.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $journal = Journal::findOrFail($id);
        if ($journal->user_id !== Auth::id()) {
            abort(403);
        }

        // Update data jurnal
        $journal->update([
            'date' => $request->date,
            'day_number' => $request->day_number,
            'job_name' => $request->job_name,
            'activity' => $request->activity,
            'obstacle' => $request->obstacle,
            'status' => 'pending', // Set status kembali ke pending setelah diedit
        ]);

        // Simpan gambar dokumentasi baru jika ada
        if ($request->hasFile('documentation')) {
            foreach ($request->file('documentation') as $file) {
                $path = $file->store('foto_jurnal', 'public');
                JournalImage::create([
                    'journal_id' => $journal->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('siswa.riwayat')->with('success', 'Jurnal berhasil diperbarui dan menunggu persetujuan kembali.');
    }
    
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        if ($journal->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus gambar terlebih dahulu
        foreach ($journal->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $journal->delete();

        return redirect()->route('siswa.riwayat')->with('success', 'Jurnal berhasil dihapus.');
    }
    
    public function deleteImage($imageId)
    {
        $image = JournalImage::findOrFail($imageId);
        $journal = $image->journal;

        // Pastikan gambar milik jurnal siswa yang sedang login
        if ($journal->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}