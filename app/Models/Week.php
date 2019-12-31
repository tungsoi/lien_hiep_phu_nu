<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brazzer\Admin\Traits\AdminBuilder;
use App\Models\MemberExam;
use App\Models\Answer;

class Week extends Model
{
    use AdminBuilder;
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "weeks";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['name', 'date_start', 'date_end', 'user_id_created', 'status'];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function userCreated() {
        return $this->hasOne('App\User', 'id', 'user_id_created');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function questions() {
        return $this->hasMany('App\Models\Question', 'week_id', 'id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function memberExam() {
        return $this->hasMany('App\Models\MemberExam', 'week_id', 'id');
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return int
     */
    public static function countNumberUserCorrect($id) {

        $members = MemberExam::select('member_id')->groupBy('member_id')->get()->toArray();
        if (!is_null($members)) {
            $number_people_correct = 0;

            // danh sach id nguoi tra loi
            foreach ($members as $member) {
                $member_id = $member['member_id'];

                // cau tra loi cuoi cung
                $answer_obj = MemberExam::select('answer')->where('member_id', $member_id)->where('week_id', $id)->orderBy('created_at', 'desc')->first();

                if (!is_null($answer_obj)) {
                    $answer = $answer_obj->toArray();

                    // dap an tra loi
                    $collection = json_decode($answer['answer']);
                    $flag = false;

                    // check cac dap an tra loi
                    foreach ($collection as $question_id => $answer_id) {
                        $answer_correct_db = Answer::where('question_id', $question_id)->where('is_correct', 1)->first();

                        // so sanh id cau tra loi trong db va ca tra loi cua khach
                        if ((int) $answer_correct_db->id == (int) $answer_id->answer_correct) { // dung
                            $flag = true;
                        } else { // sai
                            $flag = false;
                            break;
                        }
                    }

                    // check flag
                    if ($flag) {
                        $number_people_correct++;
                    }
                }
            }

            return $number_people_correct;
        }

        return 0;
    }
}
