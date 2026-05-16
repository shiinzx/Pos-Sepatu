<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::all();
        return view('promos.index', compact('promos'));
    }

    public function create()
    {
        return view('promos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $promo = Promo::create($request->all());
        LogHelper::record('Tambah Promo', "Menambahkan promo {$promo->name} diskon {$promo->discount_percentage}%");

        return redirect()->route('promos.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promo $promo)
    {
        return view('promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $promo->update($request->all());
        LogHelper::record('Edit Promo', "Mengedit promo {$promo->name}");

        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $promoName = $promo->name;
        $promo->delete();
        LogHelper::record('Hapus Promo', "Menghapus promo {$promoName}");

        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
    }
}
