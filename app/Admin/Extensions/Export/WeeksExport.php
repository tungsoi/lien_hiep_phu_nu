<?php

namespace App\Admin\Extensions\Export;

use Brazzer\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Week;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WeeksExport implements FromView
{
    public function view(): View
    {
        return view('admin.exports.week', [
            'weeks' => Week::all()
        ]);
    }
}
