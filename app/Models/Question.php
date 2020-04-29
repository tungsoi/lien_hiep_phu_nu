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

    /**
     * Change number to charracter
     *
     * @return void
     */
    public static function getArrayString($key) {
        $data = [
            0 => 'A',
            1 => 'B',
            2 => 'C',
            3 => 'D',
            4 => 'E',
            5 => 'F',
            6 => 'G',
            7 => 'H',
            8 => 'I',
            9 => 'K',
            10 => 'L',
            11 => 'M',
            12 => 'N',
            13 => 'O'
        ];

        return $data[$key] ?? "";
    }
}
