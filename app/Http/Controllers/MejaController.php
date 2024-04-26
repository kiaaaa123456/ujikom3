<?php

namespace App\Http\Controllers;

use App\Exports\MejaExport;
use App\Models\Meja;
use App\Http\Requests\StoreMejaRequest;
use App\Http\Requests\UpdateMejaRequest;
use App\Imports\MejaImport;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['meja'] = Meja::orderBy('created_at', 'DESC')->get();

            return view('meja.index')->with($data);
        } catch (QueryException | Exception | PDOException $error) {
            $this->failResponses($error->getMessage(), $error->getCode());
        }
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
    public function store(StoreMejaRequest $request)
    {
        Meja::create($request->all());
        return redirect('meja')->with('success', 'Data Meja berhasil di tambahkan!');
    }

    public function mejaPdf()
    {
        $date = date('Y-m-d');
        $data = Meja::all();
        $pdf = PDF::loadView('meja/meja-pdf', ['meja' => $data]);
        return $pdf->download($date . '_meja.pdf');
    }

    public function mejaExport()
    {
        $date = date('Y-m-d');
        return Excel::download(new MejaExport, $date . '_jenis.xlsx');
    }

    public function importData(Request $request)
    {

        Excel::import(new MejaImport, $request->import);
        return redirect()->back()->with('success', 'Import data meja berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meja $meja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMejaRequest $request, Meja $meja)
    {
        $meja->update($request->all());
        return redirect('meja')->with('success', 'Update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Meja::find($id)->delete();
        return redirect('meja')->with('success', 'Data Meja berhasil dihapus!');
    }
}
