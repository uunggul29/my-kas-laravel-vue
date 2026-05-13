<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KasController extends Controller
{
    public function index()
    {
        return Inertia::render('Kas/Index', [
            'transactions' => Transaction::latest()->get() ?? [],
            'summary' => [
                'total_masuk' => (int) Transaction::where('jenis', 'masuk')->sum('nominal'),
                'total_keluar' => (int) Transaction::where('jenis', 'keluar')->sum('nominal'),
                'saldo_akhir' => (int) Transaction::where('jenis', 'masuk')->sum('nominal') - (int) Transaction::where('jenis', 'keluar')->sum('nominal'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'jenis' => 'required|in:masuk,keluar',
        ]);

        Transaction::create($validated);
        return redirect()->back();
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Proses hapus
        $transaction->delete();

        return redirect()->to('/kas', 303);
    }
}
