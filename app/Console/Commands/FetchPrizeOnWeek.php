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

            // Check nguoi tra loi dung va fetch giai thuong
            $week = Week::where('status', 1)->first();
            $prizes = $week->prizes;
            $exams = MemberExam::where('week_id', $week->id)->where('result', 1)->where('created_at', '<', $week->date_end)->get();

            if ($exams) {
                foreach ($exams as $exam) {
                    $sub = $exam->people_number > $exams->count() ? $exam->people_number - $exams->count() : - $exam->people_number + $exams->count();

                    if ($exam->sub == "") {
                        $exam->sub = $sub;
                        $exam->save();
                    }
                }

                $list = MemberExam::where('week_id', $week->id)
                        ->whereNotNull('sub')
                        ->orderBy('sub', 'asc')
                        ->orderBy('created_at', 'asc')
                        ->limit(11)
                        ->get();

                foreach ($prizes as $key => $prize) {
                    $prize->member_exam_id = $list[$key]->id;
                    $prize->save();
                }
            }

            echo "- success\n";
            return true;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
