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
    public static function countNumberUserCorrect($weekId) {
        $data = MemberExam::where('week_id', $weekId)->where('result', 1)->get();
        return $data->groupBy('user_id')->count();
    }

    public function prizes() {
        return $this->hasMany('App\Models\WeekPrize', 'week_id', 'id');
    }
}
