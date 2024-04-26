<?php

namespace App\Http\Requests;

use App\Models\Category;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use PDOException;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Data nama Category belum diisi!'
        ];
    }

    public function store(StoreCategoryRequest $request)
    {
        //eror handling
        try {
            DB::beginTransaction(); //mulai transaksi
            Category::create($request->all()); //query input ke tabel

            DB::commit(); //nyimpan data ke db

            //untuk merefresh ke halaman itu kembali untuk melihat hasil input
            return redirect('category')->with('success', "Input data berhasil");
        } catch (QueryException | Exception | PDOException $error) {
            DB::rollBack();
            $this->failResponses($error->getMessage(), $error->getCode());
        }
    }
}
