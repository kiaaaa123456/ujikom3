<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Imports\CategoryImport;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['category'] = Category::orderBy('created_at', 'DESC')->get();

            return view('category.index')->with($data);
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
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->all());

        return redirect('category')->with('success', 'Data Category berhasil ditambahkan!');
    }

    public function categoryPdf()
    {
        $date = date('Y-m-d');
        $data = Category::all();
        $pdf = PDF::loadView('category/category-pdf', ['category' => $data]);
        return $pdf->download($date . '_category.pdf');
    }

    public function categoryExport()
    {
        $date = date('Y-m-d');
        return Excel::download(new CategoryExport, $date . '_category.xlsx');
    }

    public function importData(Request $request)
    {
        Excel::import(new CategoryImport, $request->import);
        return redirect()->back()->with('success', 'Import data category berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect('category')->with('success', 'Update data berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('category')->with('success', 'Data Category berhasil dihapus!');
    }
}
