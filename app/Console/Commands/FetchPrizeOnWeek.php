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
        // Chua check group by member
        $week = Week::where('status', 1)->first();
        $prizes = $week->prizes->count();
        $exams = MemberExam::where('week_id', $week->id)->where('result', 1)->orderBy('created_at', 'asc')->limit($prizes)->get();
        foreach ($exams as $key => $exam) {
            $gift = WeekPrize::where('week_id', $week->id)->where('order', $key+1)->first();
            $gift->member_exam_id = $exam->id;
            $gift->save();
        }

        echo "- success\n";
        return true;
    }
}
