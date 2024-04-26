<?php

namespace App\Http\Controllers;

use App\Exports\StokExport;
use App\Models\Menu;
use App\Http\Requests\StoreStokRequest;
use App\Http\Requests\UpdateStokRequest;
use App\Models\Stok;
use App\Models\Jenis;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['stok'] = Stok::with(['menu'])->get();
        $data['menu'] = Menu::get();
        return view('stok.index')->with($data);
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
    public function store(StoreStokRequest $request)
    { {
            $stok = Stok::where('menu_id', $request->menu_id)->get()->first();
            if (!$stok) {
                Stok::create($request->all());
                return redirect('stok')->with('success', 'Data Stok berhasil di tambahkan!');
            }
            $stok->jumlah = (int)$stok->jumlah + (int)$request->jumlah;
            $stok->save();

            return redirect('stok')->with('success', 'Data Stok berhasil di tambahkan!');
        }
    }


    public function stokPdf()
    {
        $date = date('Y-m-d');
        $data = Stok::all();
        $pdf = PDF::loadView('stok/stok-pdf', ['stok' => $data]);
        return $pdf->download($date . '_stok.pdf');
    }

    public function stokExport()
    {
        $date = date('Y-m-d');
        return Excel::download(new StokExport, $date . '_stok.xlsx');
    }

    /**
     * Display the specified resource.
     */
    public function show(stok $stok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stok $stok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStokRequest $request, string $id)
    {
        $stok = Stok::find($id)->update($request->all());
        return redirect('stok')->with('success', 'Update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Stok::find($id)->delete();
        return redirect('stok')->with('success', 'Data stok berhasil dihapus!');
    }
}
