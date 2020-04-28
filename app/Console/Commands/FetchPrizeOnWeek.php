<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Answer;
use App\Models\Member;
use App\Models\MemberExam;
use App\Models\Prize;
use App\Models\Question;
use App\Models\Week;
use App\Models\WeekPrize;

class FetchPrizeOnWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:prize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

// Xử lý dữ liệu trả lời của tuần hiện tại
            // Tuần thi hiện tại
            $week = Week::where('status', 1)->first();

            // Danh sách giải thưởng của tuần quay
            $prizes = $week->prizes;

            // Danh sách tất cả các câu trả lời đúng (chưa check trùng người tham gia)
            $exams = MemberExam::where('week_id', $week->id)
                ->where('result', 1)
                ->where('created_at', '<', $week->date_end)
                ->get();

            // Số lượng người tham gia có câu trả lời đúng
            $number_people_corrects = $exams->groupBy('user_id')->count();

            if ($exams) {
                foreach ($exams as $exam) {
                    // Tính hiệu số giữa dự đoán và số người trả lời đúng thực tế
                    $sub = $exam->people_number > $number_people_corrects
                        ? $exam->people_number - $number_people_corrects
                        : - $exam->people_number + $number_people_corrects;

                    // Update vào database
                    if ($exam->sub == "") {
                        $exam->sub = $sub;
                        $exam->save();
                    }
                }

                // Lấy list câu trả lời sau khi đã sắp xếp theo số dự đoán
                $list = MemberExam::where('week_id', $week->id)
                        ->whereNotNull('sub')
                        ->orderBy('sub', 'asc')
                        ->orderBy('created_at', 'asc')
                        ->get();

                // Lọc trùng 1 người trà lời
                $list_unique = $list->groupBy('user_id');

                // Lấy ra id cuối cùng
                $data_final = [];
                $flag = 0;
                foreach ($list_unique as $key => $row) {
                    if ($flag < 8) {
                        $data_final[] = $row[0]->id;
                    }
                    $flag++;
                }

                // Đẩy vào danh sách giải bảng week_prizes
                foreach ($prizes as $key => $prize) {
                    if (isset($data_final[$key]) ) {
                        $prize->member_exam_id = $data_final[$key];
                        $prize->save();
                    }
                }
            }

// Đổi trạng thái sang tuần thi khác

            echo "- success\n";
            return true;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
