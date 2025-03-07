<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as FacadesFile;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parse['produks'] = Produk::latest()->get();
        return view('admin.produk.index', $parse);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parse['kategoris'] = Kategori::latest()->get();
        return view('admin.produk.create', $parse);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'berat' => 'required|numeric',
            'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
            'deskripsi' => 'required',
        ]);

        // PROSES FILE GAMBAR
        $file = $request->file('gambar');
        $nameFile = 'tokovel-' . $file->getClientOriginalName();
        $file->move('img/produk', $nameFile);
        Produk::create([
            'id_prd' => Str::uuid(),
            'kat_id' => $request->kategori,
            'nm_prd' => Str::title($request->nama),
            'slug_prd' => Str::kebab($request->nama),
            'hrg_prd' => $request->harga,
            'stok_prd' => $request->stok,
            'brt_prd' => $request->berat,
            'gbr_prd' => $nameFile,
            'desk_prd' => $request->deskripsi,
        ]);

        return redirect()->route('produk.index')
            ->with('alert-primary', 'Selamat, produk berhasil ditambahkan');
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
        $parse['produk'] = Produk::find($id);
        $parse['kategoris'] = Kategori::latest()->get();
        return view('admin.produk.edit', $parse);
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
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'berat' => 'required|numeric',
            'gambar' => 'file|image|mimes:jpeg,png,jpg|max:1024',
            'deskripsi' => 'required',
        ]);
        $produk = Produk::find($id);
        // PROSES FILE GAMBAR
        if ($request->file('gambar') != '') {
            // delete file

            FacadesFile::delete('img/produk/' . $produk->gbr_prd);
            // move File
            $file = $request->file('gambar');
            $nameFile = 'tokovel-' . $file->getClientOriginalName();
            $file->move('img/produk', $nameFile);
        } else {
            $nameFile = $produk->gbr_prd;
        }
        $produk->update([
            'id_prd' => Str::uuid(),
            'kat_id' => $request->kategori,
            'nm_prd' => Str::title($request->nama),
            'slug_prd' => Str::kebab($request->nama),
            'hrg_prd' => $request->harga,
            'stok_prd' => $request->stok,
            'brt_prd' => $request->berat,
            'gbr_prd' => $nameFile,
            'desk_prd' => $request->deskripsi,
        ]);
        return redirect()->route('produk.index')
            ->with('alert-warning', 'Selamat, produk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $produk = Produk::find($id);
        // delete file
        FacadesFile::delete('img/produk/' . $produk->gbr_prd);
        $produk->delete();
        return redirect()->route('produk.index')
            ->with('alert-danger', 'Selamat, produk berhasil dihapus');
    }
}
