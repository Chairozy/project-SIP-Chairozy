<?php

namespace App\Imports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Buku([
            'userpost_id' => $row[1],
            'cover' => $row[2],
            'cover_path' => '',
            'pdf' => $row[4],
            'pdf_path' => '',
            'judul' => $row[6],
            'jumlah' => $row[7],
            'pengarang' => $row[8],
            'penerbit' => $row[9],
            'terbit' => $row[10],
            'tebal_buku' => $row[11],
            'harga' => $row[12],
            'harga_sebelumnya' => $row[13],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
