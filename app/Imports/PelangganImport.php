<?php

namespace App\Imports;

use App\Models\Pelanggan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pelanggan::create([
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
                'no_telp' => $row['no_telp'],
                'email' => $row['email'],
            ]);
        }
    }
}
