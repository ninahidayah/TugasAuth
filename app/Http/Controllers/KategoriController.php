<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::get();

        return view('kategori\index', ['kategori' => $kategori]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
        return view('kategori.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function simpan(Request $request)
    {
        Kategori::create(['nama' => $request->nama]);

        return redirect()->route('kategori');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::find($id)->first();

        return view('kategori.form', ['kategori' => $kategori]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Kategori::find($id)->update(['nama' => $request->nama]);

        return redirect()->route('kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        // Periksa terlebih dahulu apakah ada referensi foreign key pada tabel lain
        $barangCount = Barang::where('id_kategori', $id)->count();
        if ($barangCount > 0) {
            return redirect()->route('kategori')->with('error', 'Tidak dapat menghapus kategori karena masih terdapat barang yang menggunakan kategori tersebut.');
        }

        // Hapus data pada tabel "kategori"
        Kategori::destroy($id);

        // Perbarui referensi foreign key pada tabel lain jika ada
        // ...

        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
