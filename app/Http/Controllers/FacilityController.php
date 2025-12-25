<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        $facilityTypes = [
            'sekolah' => 'Sekolah',
            'rumah_sakit' => 'Rumah Sakit',
            'puskesmas' => 'Puskesmas',
            'tempat_ibadah' => 'Tempat Ibadah',
            'pasar' => 'Pasar',
            'lainnya' => 'Lainnya'
        ];

        return view('facilities.index', compact('facilities', 'facilityTypes'));
    }

    public function dashboard()
    {
        $facilities = Facility::all();
        $facilityTypes = [
            'sekolah' => 'Sekolah',
            'rumah_sakit' => 'Rumah Sakit',
            'puskesmas' => 'Puskesmas',
            'tempat_ibadah' => 'Tempat Ibadah',
            'pasar' => 'Pasar',
            'lainnya' => 'Lainnya'
        ];

        return view('facilities.dashboard', compact('facilities', 'facilityTypes'));
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sekolah,rumah_sakit,puskesmas,tempat_ibadah,pasar,lainnya',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        Facility::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sekolah,rumah_sakit,puskesmas,tempat_ibadah,pasar,lainnya',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        $facility->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Fasilitas berhasil diperbarui!');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }


    public function getFacilitiesByType(Request $request)
    {
        $query = Facility::query();

        // filter berdasarkan jenis
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        return response()->json($query->get());
    }
}
