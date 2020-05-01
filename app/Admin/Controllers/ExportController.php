<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Controllers\Controller;
use App\Models\MemberExam;
use App\Models\Question;
use App\User;

class ExportController extends Controller implements FromCollection, WithHeadings
{
    use Exportable;
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }


    public function collection()
    {
        $orders = MemberExam::where('week_id', $this->data['week_id']);
        if ($this->data['result'] != "") {
            $orders->where('result', $this->data['result']);
        }

        if ($this->data['user_name'] != "") {
            $user = User::where('name', 'like', '%'.$this->data['user_name'].'%')->first();
            if ($user) {
                $orders->where('user_id', $user->id);
            }
        }

        $orders->orderBy('created_at', 'asc');

        foreach ($orders->get() as $key => $row) {
            $order[] = array(
                '0' => $key+1,
                '1' => $row->member->name ?? "Đang cập nhật",
                '2' => $this->fetchAnswer($row->answer),
                '3' => $row->result == 1 ? "Đúng" : "Sai",
                '4' => $row->people_number,
                '5' => date('H:i - d/m/Y', strtotime($row->created_at))
            );
        }

        return (collect($order));
    }

    public function headings(): array
    {
        return [
            'Số thứ tự',
            'Tên người dự thi',
            'Câu trả lời',
            'Kết quả',
            'Dự đoán số người trả lời đúng',
            'Thời gian trả lời',
        ];
    }

    public function fetchAnswer($answerRow)
    {
        if (!is_null($answerRow)) {
            $answer = json_decode($answerRow);
            if (!is_null($answer)) {
                $html = "";
                $key_ques = 1;
                foreach ($answer as $key => $element) {
                    $question_id = str_replace("question_id_", "", $key);
                    $question = Question::find($question_id);
                    $arr_answers = explode(',', $element);
                    unset($arr_answers[sizeof($arr_answers)-1]);

                    $all_answers = Question::getArrAnswer($question_id);
                    $char = [];
                    if (sizeof($arr_answers) > 0) {
                        foreach ($arr_answers as $row) {
                            $key = array_search((int) $row, $all_answers);
                            $char[] = Question::getArrayString($key);
                        }
                    }

                    $char_str = implode(', ', $char);

                    $html .= "Câu hỏi: ".$key_ques." - Đáp án: $char_str<br>";
                    $key_ques++;
                }
                return $html;
            }
        }

        return null;
    }
}
