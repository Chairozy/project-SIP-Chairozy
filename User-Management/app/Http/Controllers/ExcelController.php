<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExcelExport;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request)
    {
        $input = array("no", "no");
        if (!is_null($request->in)) {
            $input = $request->in;
        }
        return Excel::download(new ExcelExport($request->si, $input, $request->hcn), 'excel.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new ExcelImport, $request->file('excel'));
        return redirect()->route('buku');
    }
}
