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

class ChangeWeekQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:week';

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
        if (!is_null($week) && $week->date_end < date('Y-m-d H:i:s', strtotime(now()))) {

        dd('oke');
            $week->status = 2;
            $week->save();

            $nextWeek = Week::where('status', 0)->where('date_start', '>', $week->date_end)->orderBy('date_start', 'asc')->first();
            if (!is_null($nextWeek)) {
                $nextWeek->status = 1;
                $nextWeek->save();
            }
        }

        echo "- success\n";
        return true;
    }
}
