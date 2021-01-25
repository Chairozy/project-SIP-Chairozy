<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExcelExport;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export()
    {
        return Excel::download(new ExcelExport, 'excel.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new ExcelImport, $request->file('excel'));
        return redirect()->route('buku');
    }
}
