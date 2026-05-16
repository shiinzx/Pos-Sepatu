<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Models\Category;
use App\Models\Promo;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class ShoeController extends Controller
{
    public function index()
    {
        $shoes = Shoe::with(['category', 'promo'])->get();
        return view('shoes.index', compact('shoes'));
    }

    public function create()
    {
        $categories = Category::all();
        $promos = Promo::all();
        return view('shoes.create', compact('categories', 'promos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'promo_id' => 'nullable|exists:promos,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'size' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
        ]);
        
        $shoe = Shoe::create($request->all());
        LogHelper::record('Tambah Sepatu', "Menambahkan sepatu {$shoe->name} stok {$shoe->stock}");

        return redirect()->route('shoes.index')->with('success', 'Sepatu berhasil ditambahkan.');
    }

    public function show(Shoe $shoe)
    {
        return view('shoes.show', compact('shoe'));
    }

    public function edit(Shoe $shoe)
    {
        $categories = Category::all();
        $promos = Promo::all();
        return view('shoes.edit', compact('shoe', 'categories', 'promos'));
    }

    public function update(Request $request, Shoe $shoe)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'promo_id' => 'nullable|exists:promos,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'size' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $oldStock = $shoe->stock;
        $shoe->update($request->all());
        
        if ($oldStock != $shoe->stock) {
            LogHelper::record('Update Stok', "Mengubah stok sepatu {$shoe->name} dari {$oldStock} menjadi {$shoe->stock}");
        } else {
            LogHelper::record('Edit Sepatu', "Mengedit data sepatu {$shoe->name}");
        }

        return redirect()->route('shoes.index')->with('success', 'Sepatu berhasil diperbarui.');
    }

    public function destroy(Shoe $shoe)
    {
        $shoeName = $shoe->name;
        $shoe->delete();
        LogHelper::record('Hapus Sepatu', "Menghapus sepatu {$shoeName}");

        return redirect()->route('shoes.index')->with('success', 'Sepatu berhasil dihapus.');
    }
}
