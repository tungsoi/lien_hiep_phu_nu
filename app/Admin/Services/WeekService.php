<?php

namespace App\Admin\Services;

use App\Models\Answer;
use App\Models\Week;
use App\Models\Prize;
use App\Models\Question;
use App\Models\WeekPrize;

class WeekService {

    private $model;
    private $prizeModel;
    private $weekPrizeModel;
    private $question;
    private $answer;

    /**
     * Constructator
     */
    public function __construct()
    {
        $this->model = new Week();
        $this->prizeModel = new Prize();
        $this->weekPrizeModel = new WeekPrize();
        $this->question = new Question();
        $this->answer = new Answer();
    }

    /**
     * Create new week
     *
     * @param array $data
     * @return object
     */
    public function create($data = []) {
        return $this->model->create($data);
    }

    /**
     * Add list prize to week by week_id
     * List prize get in tbl_prizes
     *
     * @param integer $weekId
     * @return boolean
     */
    public function addPrize(int $weekId = null) {
        if (! is_null($weekId)) {
            $prizes = $this->prizeModel->all()->toArray();

            if (!is_null($prizes)) {
                foreach ($prizes as $key => $prize) {
                    for ($i = 0; $i < $prize['number']; $i++) {
                        $this->weekPrizeModel->create([
                            'week_id'   =>  $weekId,
                            'prize_id'  =>  $prize['id'],
                            'order' =>  $this->weekPrizeModel->where('week_id', $weekId)->count() + 1
                        ]);
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Create questions and answers of a week by week id and response data
     *
     * @param integer $weekId
     * @param array $data
     * @return boolean
     */
    public function createQuestionAndAnswer(int $weekId = null, $data = []) {
        if (isset($data['questions'])) {
            foreach ($data['questions'] as $question_item) {
                if (! is_null($question_item['title'])) {
                    $question = $this->question->create([
                        'week_id'   =>  $weekId,
                        'title'     =>  $question_item['title']
                    ]);

                    if (isset($question_item['answer'])) {
                        foreach ($question_item['answer'] as $answer_item) {
                            if (!is_null($answer_item['content'])) {
                                $this->answer->create([
                                    'question_id'   =>  $question->id,
                                    'content'       =>  $answer_item['content'],
                                    'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                ]);
                            }
                        }
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Update a week
     *
     * @param array $data
     * @return boolean
     */
    public function update($data = []) {
        return $this->model->find($data['id'])->update($data);
    }

    /**
     * Update questions and answers of a week by response data
     *
     * @param array $data
     * @return void
     */
    public function updateQuestionAndAnswer($data = []) {
        if (isset($data['questions'])) {
            foreach ($data['questions'] as $question_item) {
                if (is_null($question_item['id'])) { // add new question
                    if (!is_null($question_item['title'])) {
                        $question = $this->question->create([
                            'week_id'   =>  $data['id'],
                            'title'     =>  $question_item['title']
                        ]);

                        if (isset($question_item['answer'])) {
                            foreach ($question_item['answer'] as $answer_item) {
                                if (!is_null($answer_item['content'])) {
                                    $this->answer->create([
                                        'question_id'   =>  $question->id,
                                        'content'       =>  $answer_item['content'],
                                        'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                    ]);
                                }
                            }
                        }
                    }
                } else { // question old
                    if ($question_item['_remove_'] == 1) { // delete question
                        $this->question->find($question_item['id'])->delete();
                        $this->answer->where('question_id', $question_item['id'])->delete();
                    } else { // nothing
                        $this->question->find($question_item['id'])->update([
                            'title' =>  $question_item['title']
                        ]);
                        $current_arr_answers = $this->question->getArrAnswer($question_item['id']);

                        if (isset($question_item['answer'])) {
                            $arr_answers = [];

                            foreach ($question_item['answer'] as $answer_item) {
                                if (! isset($answer_item['answer_id'])) { // add new answer
                                    $this->answer->create([
                                        'question_id'   =>  $question_item['id'],
                                        'content'       =>  $answer_item['content'],
                                        'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                    ]);
                                } else { // answers old
                                    $arr_answers[] = $answer_item['answer_id'];
                                    $this->answer->find($answer_item['answer_id'])->update([
                                        'content'       =>  $answer_item['content'],
                                        'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                    ]);
                                }
                            }

                            $diff = array_diff($current_arr_answers, $arr_answers); // array(1, 2, 3) -> list id answer not delete
                            if (! empty($diff)) {
                                foreach ($diff as $answer_id) {
                                    $this->answer->find($answer_id)->delete();
                                }
                            }
                        } else { // delete all answers
                            foreach ($current_arr_answers as $answer_id) {
                                $this->answer->find($answer_id)->delete();
                            }
                        }
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Undocumented function
     *
     * @param [type] $res
     * @return void
     */
    public static function checkResultAnswer($res) {

        if (!is_null($res)) {
            foreach ($res as $key => $question) {
                $questionId = str_replace("question_id_", "", $key);
                $answerIdArr = explode(",", $question['answer_id']);

                if (!is_null($answerIdArr)) {
                    foreach ($answerIdArr as $answerId) {
                        if ($answerId != "") {
                            $checkCorrect = Answer::find($answerId)->is_correct == 1 ? true : false;

                            if (! $checkCorrect) { return false; }
                        }
                    }
                }
            }

            return true;
        }

        return false;
    }
}
