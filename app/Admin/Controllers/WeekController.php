<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Brazzer\Admin\Controllers\HasResourceActions;
use Brazzer\Admin\Form;
use Brazzer\Admin\Grid;
use Brazzer\Admin\Layout\Content;
use Brazzer\Admin\Show;
use App\Models\Week;
use Brazzer\Admin\Facades\Admin;
use Brazzer\Admin\Extensions\HasManyNested;
use Illuminate\Http\Request;
use DB;
use App\Admin\Extensions\Show\QuestionHaveAnswer;

class WeekController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Tuần thi trắc nghiệm')
            ->description('Danh sách')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Tuần thi trắc nghiệm')
            ->description('Chi tiết')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Tuần thi trắc nghiệm')
            ->description('Chỉnh sửa')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Tuần thi trắc nghiệm')
            ->description('Tạo mới')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Week);

        $grid->name(trans('admin.week_name'))->editable();
        $grid->date_start(trans('admin.date_start'))->display(function() {
            return date('H:i - d/m/Y', strtotime($this->date_start));
        });
        $grid->date_end(trans('admin.date_end'))->display(function() {
            return date('H:i - d/m/Y', strtotime($this->date_end));
        });
        $grid->number_questions(trans('admin.number_question'))->display(function () {
            return sizeof($this->questions);
        });
        $grid->user_id_created(trans('admin.user_created'))->display(function () {
            return $this->userCreated->name;
        });
        $grid->status(trans('admin.status'))->display(function () {
            switch ($this->status) {
                case 0: return '<span class="label label-default">'.trans('admin.not_started').'</span>';
                case 1: return '<span class="label label-success">'.trans('admin.running').'</span>';
                case 2: return '<span class="label label-danger">'.trans('admin.stop').'</span>';
            }
        });

        $grid->created_at(trans('admin.created_at'))->display(function() {
            return date('H:i - d/m/Y', strtotime($this->created_at));
        });

        $grid->disableExport(false);
        $grid->actions(function ($grid) {
            $grid->disableDelete(false);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Week::findOrFail($id));

        $show->name(trans('admin.week_name'));

        $show->date_start(trans('admin.date_start'))->as(function() {
            return date('H:i - d/m/Y', strtotime($this->date_start));
        });
        $show->date_end(trans('admin.date_end'))->as(function() {
            return date('H:i - d/m/Y', strtotime($this->date_end));
        });
        $show->number_questions(trans('admin.number_question'))->as(function () {
            return sizeof($this->questions);
        });
        $show->user_id_created(trans('admin.user_created'))->as(function () {
            return $this->userCreated->name;
        })->label();
        $show->created_at(trans('admin.created_at'))->as(function() {
            return date('H:i - d/m/Y', strtotime($this->created_at));
        });
        $show->divider();
        $show->question_answer(trans('admin.questions'))->as(function () {
             $week = Week::find($this->id);
             return view('admin.week.question_answers', compact('week'));
        });

        Admin::script($this->script());
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Week);

        $form->hidden('id', 'ID');
        $form->text('name', 'Tên tuần thi');
        $form->datetime('date_start', 'Ngày bắt đầu');
        $form->datetime('date_end', 'Ngày kết thúc');
        $form->hidden('user_id_created')->default(Admin::user()->id);

        $form->divider('Danh sách câu hỏi');

        $form->hasManyNested('questions','Câu hỏi', function (Form\NestedForm $question) {
            $question->text('title', 'Nội dung câu hỏi');
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        if ($request->all() != null) {
            $week = Week::create([
                'name'              =>  $request->name,
                'date_start'        =>  $request->date_start,
                'date_end'          =>  $request->date_end,
                'user_id_created'   =>  $request->user_id_created
            ]);

            if (isset($request->questions)) {
                foreach ($request->questions as $question_item) {
                    if (!is_null($question_item['title'])) {
                        $question = Question::create([
                            'week_id'   =>  $week->id,
                            'title'     =>  $question_item['title']
                        ]);

                        if (isset($question_item['answer'])) {
                            foreach ($question_item['answer'] as $answer_item) {
                                if (!is_null($answer_item['content'])) {
                                    Answer::create([
                                        'question_id'   =>  $question->id,
                                        'content'       =>  $answer_item['content'],
                                        'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        admin_toastr(trans('admin.save_succeeded'), 'success');
        return redirect()->route('weeks.index');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request) {
        if ($request->all() != null) {
            Week::find($request->id)->update([
                'name'              =>  $request->name,
                'date_start'        =>  $request->date_start,
                'date_end'          =>  $request->date_end,
                'user_id_created'   =>  $request->user_id_created
            ]);

            if (isset($request->questions)) {
                foreach ($request->questions as $question_item) {
                    if (is_null($question_item['id'])) { // add new question
                        if (!is_null($question_item['title'])) {
                            $question = Question::create([
                                'week_id'   =>  $request->id,
                                'title'     =>  $question_item['title']
                            ]);

                            if (isset($question_item['answer'])) {
                                foreach ($question_item['answer'] as $answer_item) {
                                    if (!is_null($answer_item['content'])) {
                                        Answer::create([
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
                            Question::find($question_item['id'])->delete();
                            Answer::where('question_id', $question_item['id'])->delete();
                        } else { // nothing
                            Question::find($question_item['id'])->update([
                                'title' =>  $question_item['title']
                            ]);
                            $current_arr_answers = Question::getArrAnswer($question_item['id']);

                            if (isset($question_item['answer'])) {
                                $arr_answers = [];

                                foreach ($question_item['answer'] as $answer_item) {
                                    if (! isset($answer_item['answer_id'])) { // add new answer
                                        Answer::create([
                                            'question_id'   =>  $question_item['id'],
                                            'content'       =>  $answer_item['content'],
                                            'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                        ]);
                                    } else { // answers old
                                        $arr_answers[] = $answer_item['answer_id'];
                                        Answer::find($answer_item['answer_id'])->update([
                                            'content'       =>  $answer_item['content'],
                                            'is_correct'    =>  isset($answer_item['checkbox']) ? 1 : 0
                                        ]);
                                    }
                                }

                                $diff = array_diff($current_arr_answers, $arr_answers); // array(1, 2, 3) -> list id answer not delete
                                if (! empty($diff)) {
                                    foreach ($diff as $answer_id) {
                                        Answer::find($answer_id)->delete();
                                    }
                                }
                            } else { // delete all answers
                                foreach ($current_arr_answers as $answer_id) {
                                    Answer::find($answer_id)->delete();
                                }
                            }
                        }
                    }
                }
            }
        }

        admin_toastr(trans('admin.save_succeeded'), 'success');
        return redirect()->back();
    }

    public function script() {
        return <<<EOT
        $( document ).ready(function() {
            var content = $('.form-group').eq(6).find('.box-body').html();
            if (content != undefined)
            {
                content = content.replace(/&lt;/g, '<');
                content = content.replace(/&gt;/g, '>');
                content = content.replace('&nbsp;', '');
                $('.form-group').eq(6).find('.box-body').html(content);
            }
        });

EOT;
    }
}
