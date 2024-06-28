<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $parse['transaksis'] = Transaksi::latest()->get();
        return view('admin.transaksi.index', $parse);
    }
    public function detail($id_transaksi)
    {
        $parse['transaksi'] = Transaksi::find($id_transaksi);
        return view('admin.transaksi.detail', $parse);
    }
    public function update(Request $request, $id_transaksi)
    {


        // Find the transaction by ID
        $transaksi = Transaksi::find($id_transaksi);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaction not found.');
        }

        // Update the transaction with the request data
        $transaksi->stts_trx = 'pesanan selesai';
        $transaksi->save();

        // Redirect back with success message
        return redirect()->route('transaksi.detail', $id_transaksi)
            ->with('success', 'Transaction updated successfully.');
    }
}
