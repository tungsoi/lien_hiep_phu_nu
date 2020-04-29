<?php

namespace App\Admin\Extensions\Export;

use Brazzer\Admin\Grid\Exporters\AbstractExporter;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;

class Answers extends AbstractExporter {
    protected $filename;
    public $type = "job";

    public function __construct(){
        dd('oke');
        $this->filename    = "Danh sách câu trả lời";
    }

    public function export(){
        set_time_limit(0);
        $fields       = Request::get('fields', []) ? json_decode(Request::get('fields'), true) : $this->getFields();
        $filename     = $this->filename;

        $rows[]    = array_values($fields);

        Excel::create($filename, function($excel) {

            $excel->sheet('Sheetname', function($sheet) {
                $rows = collect($this->getData())->map(function ($item) {
                    return $item;
                });
                $data = [];
                $data[] = $this->header();

                foreach ($rows->toArray() as $row) {
                    dd($row);
                }

                $sheet->rows($data);
            });

        })->export('xls');
    }

    private function getFields(){
        $fields = [];
        foreach($this->grid->columns() as $column){
            $fields[$column->getName()] = $column->getLabel();
        }
        return $fields;
    }

    public function header()
    {
        # code...
        return ['Date action','PNR','Department','User change','Board Point','Old class','Old flight','Old date flight','Old Route','New class','New flight','New date flight','New Route','Payment fee','Currency'];
    }
}
