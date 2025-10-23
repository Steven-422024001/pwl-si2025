<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier beserta ringkasan status.
     */
    public function index(): View
    {
        $totalSuppliers = Supplier::count();
        $activeCount = Supplier::where('status', 'Active')->count();
        $idleCount = Supplier::where('status', 'Idle')->count();
        $inactiveCount = Supplier::where('status', 'Inactive')->count();
        
        $suppliers = Supplier::latest()->paginate(10);

        return view('suppliers.index', compact(
            'suppliers', 'totalSuppliers', 'activeCount', 'idleCount', 'inactiveCount'
        ));
    }

    /**
     * Menampilkan form untuk membuat supplier baru.
     */
    public function create(): View
    {
        return view('suppliers.create');
    }

    /**
     * Menyimpan supplier baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data input dari form
        $request->validate([
            'supplier_name' => 'required|string|min:3',
            'contact_name'  => 'nullable|string|min:3',
            'phone'         => 'required|string|min:10',
            'address'       => 'nullable|string|min:10',
            'notes'         => 'nullable|string',
            'status'        => 'required|in:Active,Idle,Inactive', // <-- Validasi status ditambahkan
        ]);

        // 2. Insert data ke database
        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'contact_name'  => $request->contact_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'notes'         => $request->notes,
            'status'        => $request->status, // <-- Status dari form disimpan
        ]);

        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('suppliers.index')
                         ->with('success', 'Data Supplier Berhasil Disimpan!');
    }

    /**
     * Menampilkan detail satu supplier.
     */
    public function show(string $id): View
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Menampilkan form untuk mengedit supplier.
     */
    public function edit(string $id): View
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Memperbarui data supplier di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Validasi data input dari form
        $request->validate([
            'supplier_name' => 'required|string|min:3',
            'contact_name'  => 'nullable|string|min:3',
            'phone'         => 'required|string|min:10',
            'address'       => 'nullable|string|min:10',
            'notes'         => 'nullable|string',
            'status'        => 'required|in:Active,Idle,Inactive', // <-- Validasi status ditambahkan
        ]);

        // 2. Dapatkan data supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // 3. Update data di database
        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'contact_name'  => $request->contact_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'notes'         => $request->notes,
            'status'        => $request->status, // <-- Status dari form disimpan
        ]);

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('suppliers.index')
                         ->with('success', 'Data Supplier Berhasil Diubah!');
    }

    /**
     * Menghapus data supplier dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')
                         ->with('success', 'Data Supplier Berhasil Dihapus!');
    }
}