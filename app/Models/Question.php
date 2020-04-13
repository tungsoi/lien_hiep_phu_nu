<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brazzer\Admin\Traits\AdminBuilder;

class Question extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "questions";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['week_id', 'title'];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function answers() {
        return $this->hasMany('App\Models\Answer', 'question_id', 'id');
    }

    /**
     * get array answer
     *
     * @param [type] $id
     * @return array
     */
    public static function getArrAnswer($id) {
        $question = self::find($id);
        $answer = $question->answers->pluck('id')->toArray();
        return $answer;
    }

     /**
     * get array correct answer
     *
     * @param [type] $id
     * @return array
     */
    public static function getArrCorrectAnswer($id) {
        $question = self::find($id);
        $answer = $question->answers->where('is_correct', 1)->pluck('id')->toArray();
        return $answer;
    }

}
