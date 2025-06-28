<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::latest()->paginate(10);
        return view('admin.materi.kategori.index', compact('kategori'));
    }

    public function create() {
        return view('admin.materi.kategori.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255|unique:kategoris']);
        Kategori::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(Kategori $kategori) {
        return view('admin.materi.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori) {
        $request->validate(['name' => 'required|string|max:255|unique:kategoris,name,' . $kategori->id]);
        $kategori->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori) {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
