<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\productImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['product'] = Product::get();
        return view('product.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $data['harga_jual'] = $this->hitungHargaJual($request->input('harga_beli'));

        Product::create($data);
        return redirect('produk-titipan')->with('success', 'Data Product berhasil di tambahkan!');
    }

    private function hitungHargaJual($hargaBeli)
    {
        $keuntungan = $hargaBeli * 1.7;
        $hargaJual = ceil($keuntungan / 500) * 500;
        return $hargaJual;
    }


    public function productExport()
    {
        $date = date('Y-m-d');
        return Excel::download(new ProductExport, $date . 'product.xlsx');
    }

    public function productPdf()
    {
        $date = date('Y-m-d');
        $data = Product::all();
        $pdf = PDF::loadView('product.data', ['product' => $data]);
        return $pdf->download($date . '_product.pdf');
    }

    public function importData(Request $request)
    {
        Excel::import(new productImport, $request->import);
        return redirect()->back()->with('success', 'Import data produk titipan berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->all();
        $data['harga_jual'] = $this->hitungHargaJual($request->input('harga_beli'));

        Product::find($id)->update($data);
        return redirect('produk-titipan')->with('success', 'Update data berhasil');
    }

    // ...

    public function updateStok(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'stok' => 'required|numeric'
        ]);

        try {
            // Cari produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Update stok produk
            $product->stok = $request->stok;
            $product->save();

            // Redirect kembali ke halaman produk dengan pesan sukses
            return redirect('produk-titipan')->with('success', 'Stok produk berhasil diperbarui');
        } catch (\Throwable $th) {
            // Jika terjadi kesalahan, redirect dengan pesan kesalahan
            return redirect('produk-titipan')->with('error', 'Gagal memperbarui stok produk');
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect('produk-titipan')->with('success', 'Data Product berhasil dihapus!');
    }
}
