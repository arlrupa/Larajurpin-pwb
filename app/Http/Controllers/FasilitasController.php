<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Fasilitas::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fasilitas = $query->get();

        return view('pages.fasilitas.index', compact('fasilitas'));
    }

    public function create() //menampilkan form input
    {
        return view('pages.fasilitas.create');
    }

    public function store(Request $request) //meproses dan menyimpan data ke database
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'stock' => ['required', 'min:0'],
            'condition' => ['required', 'string'],
            'completeness' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048']
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) { //mengecek file sudah di uploud atau blm
            $filePath = $request->file('image')->store('uploads', 'public'); //gambarnya disimpan di folder uploud & public
            $validatedData['image'] = $filePath; //menyimpan file ke database
        }

        // Simpan data ke database
        Fasilitas::create($validatedData);

        return redirect('/fasilitas')->with('success', 'Berhasil menambahkan data');
    }


    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        return view('pages.fasilitas.edit', [
            'fasilitas' => $fasilitas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'stock' => ['required', 'min:0'],
            'condition' => ['required', 'string'],
            'completeness' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048']
        ]);

        // Ambil data fasilitas yang akan di-update
        $fasilitas = Fasilitas::findOrFail($id);

        // Cek dan hapus gambar lama jika ada file baru
        if ($request->hasFile('image')) {
            if ($fasilitas->image) {
                Storage::disk('public')->delete($fasilitas->image);
            }
            $filePath = $request->file('image')->store('uploads', 'public');
            $validatedData['image'] = $filePath;
        }

        // Update data fasilitas
        $fasilitas->update($validatedData);

        return redirect('/fasilitas')->with('success', 'Berhasil mengubah data');
    }


    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect('/fasilitas')->with('success', 'Berhasil manghapus data');
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $results = Fasilitas::where('name', 'like', '%' . $term . '%')
            ->pluck('name');

        return response()->json($results);
    }
}
