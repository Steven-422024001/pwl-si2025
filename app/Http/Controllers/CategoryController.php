<?php

namespace App\Http\Controllers;

use App\Models\Category_product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        // Ambil data kategori dengan jumlah produk
        $categories = Category_product::withCount('products')
                        ->orderBy('id', 'asc')
                        ->paginate(10);

        return view('category.index', compact('categories'));
    }

    // ------------------------------------------------------------------
    // CRUD
    // ------------------------------------------------------------------

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('category.create');
    }

    /**
     * store
     * digunakan untuk insert data ke dalam database
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data input
        $validatedData = $request->validate([
            'name'        => 'required|min:3',
            'description' => 'nullable|string'
        ]);

        // Simpan ke database
        $category = Category_product::create($validatedData);

        if ($category) {
            return redirect()->route('category.index')
                             ->with('success', 'Kategori berhasil ditambahkan!');
        }

        return redirect()->route('category.index')
                         ->with('error', 'Gagal menyimpan kategori.');
    }

    /**
     * edit
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $category = Category_product::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * update
     *
     * @param Request $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi form
        $validatedData = $request->validate([
            'name'        => 'required|min:3',
            'description' => 'nullable|string'
        ]);

        $category = Category_product::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('category.index')
                         ->with('success', 'Data kategori berhasil diubah!');
    }

    /**
     * show
     *
     * @param mixed $id
     * @return View
     */
    public function show($id): View
    {
        $category = Category_product::findOrFail($id);
        return view('category.show', compact('category'));
    }

    /**
     * destroy
     * 
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $deleted = Category_product::where('id', $id)->delete();

        if ($deleted) {
            return redirect()->route('category.index')
                             ->with('success', 'Data kategori berhasil dihapus!');
        } else {
            return redirect()->route('category.index')
                             ->with('error', 'Gagal menghapus data!');
        }
    }
}
