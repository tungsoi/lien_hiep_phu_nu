<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MemberExam;
use App\Models\Week;
use Illuminate\Support\Facades\Mail;

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
            // Tuần thi hiện tại
            $week = Week::where('status', 1)->first();

            echo "-------------------\n";
            echo "- Get current week \n";
            if (!is_null($week) && $week->date_end > date('Y-m-d H:i:s', strtotime(now()))) // run change > to <
            {
                echo "- Handing prizes... \n";
                //  --> Xử lý dữ liệu trả lời của tuần hiện tại
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
                        if ($flag < $prizes->count()) {
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

                echo "- Change status to next week \n";
                //  --> Đổi trạng thái sang tuần thi khác
                $week->status = 2;
                $week->save();

                $nextWeek = Week::where('status', 0)->where('date_start', '>', $week->date_end)->orderBy('date_start', 'asc')->first();
                if (!is_null($nextWeek)) {
                    $nextWeek->status = 1;
                    $nextWeek->save();
                }

                //  --> Gửi email thông báo cho người trúng thưởng
                foreach($data_final as $email_key => $member_exam_id) {
                    // $member_email = MemberExam::find($member_exam_id)->member->email; live
                    $member_email = 'thanhtung.atptit@gmail.com'; // test
                    $email = [
                        'view'      =>  'member.email',
                        'content'   =>  [
                            'Content'   =>  '',
                            'Header'    =>  'Thông báo trúng thưởng giải tuần Hội liên hiệp Phụ nữ Việt Nam'
                        ],
                        'subject'   =>  'Thông báo trúng thưởng giải tuần Hội liên hiệp Phụ nữ Việt Nam'
                    ];

                    echo "- $email_key - Sending email to $member_email \n";
                    // Mail::send($email['view'], [
                    //     'member_email' => $member_email,
                    //     'emailContent' => $email['content']
                    // ], function($m) use ($member_email, $email) {
                    //     $m->to($member_email, 'Khách hàng tham gia dự thi')->subject($email['subject']);
                    // });
                }
            }
            return true;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
