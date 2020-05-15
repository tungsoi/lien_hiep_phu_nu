<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\MemberExam;
use App\Models\Province;
use App\Models\Question;
use App\User;
use App\Models\Week;

class MemberExportController extends Controller implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        $orders = User::where('is_member', 1)->get();
        if ($orders->count() > 0) {
            $key = 1;
            foreach ($orders as $row) {
                if (strpos($row->email, '_guest@gmail.com')) {
                    $stremail = null;
                } else {
                    $stremail = $row->email;
                }

                $order[] = array(
                    '0' => $key,
                    '1' => $row->name,
                    '2' => $stremail,
                    '3' => $row->mobile,
                    '4' => $row->gender == 1 ? "Nam" : "Nữ",
                    '5' => $row->birthday,
                    '6' => $row->address,
                    '7' => District::where('district_id', (int) $row->district)->first()->name ?? "",
                    '8' => Province::where('province_id', (int) $row->province)->first()->name ?? ""
                );
                $key++;
            }

            return (collect($order));
        }
        return (collect([]));
    }

    public function headings(): array
    {
        return [
            'Số thứ tự',
            'Họ và tên',
            'Email',
            'Số điện thoại',
            'Giới tính',
            'Ngày sinh',
            'Số nhà / Đường / Phố',
            'Quận / Huyện',
            'Thành phố'
        ];
    }
}
