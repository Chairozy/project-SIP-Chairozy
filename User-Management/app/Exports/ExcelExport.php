<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelExport implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(array $method, array $value, array $name)
    {
        $this->method = $method;
        $this->value = $value;
        $this->name = $name;
    }

    public function query()
    {
        $data = Buku::query();
        $i = 0;
        $v = 0;
        foreach($this->method as $method){
            if ($method != "none") {
                $data->where($this->name[$i], $method, $this->value[$v]);
                $v++;
            }
            $i++;
        }   
        return $data;
    }
}
