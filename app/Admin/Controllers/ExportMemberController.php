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

class ExportMemberController extends Controller implements FromCollection, WithHeadings
{
    use Exportable;
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }


    public function collection()
    {
        $orders = MemberExam::where('week_id', $this->data['week_id'])->get();
        $orders = $orders->groupBy('user_id');

        if ($orders->count() > 0) {
            $key = 1;
            foreach ($orders as $row) {
                $res = $row[0];
                $member = $res->member;
                $order[] = array(
                    '0' => $key,
                    '1' => $member->name,
                    '2' => $member->mobile,
                    '3' => $member->gender == 1 ? "Nam" : "Nữ",
                    '4' => $member->birthday,
                    '5' => $member->address,
                    '6' => District::where('district_id', (int) $member->district)->first()->name ?? "",
                    '7' => Province::where('province_id', (int) $member->province)->first()->name ?? "",
                    '8' => Week::find($this->data['week_id'])->name
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
            'Số điện thoại',
            'Giới tính',
            'Ngày sinh',
            'Số nhà / Đường / Phố',
            'Quận / Huyện',
            'Thành phố',
            'Tuần thi tham dự'
        ];
    }
}
