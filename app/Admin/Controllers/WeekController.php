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
use App\Models\MemberExam;
use App\Admin\Extensions\Export\WeeksExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WeekPrize;
use App\Models\Prize;
use App\Admin\Services\WeekService;
use App\User;

class WeekController extends Controller {
    use HasResourceActions;

    protected $fileExportName;
    private $service;

    public function __construct() {
        $this->fileExportName = date('d-m-Y', strtotime(now()))."-weeks.xlsx";
        $this->service = new WeekService();
    }
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content) {
        return $content->header('Tuần thi trắc nghiệm')->description('Danh sách')->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content) {
        return $content->header('Tuần thi trắc nghiệm')->description('Chi tiết')->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content) {
        return $content->header('Tuần thi trắc nghiệm')->description('Chỉnh sửa')->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content) {
        return $content->header('Tuần thi trắc nghiệm')->description('Tạo mới')->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid() {
        $grid = new Grid(new Week);
        $grid->filter(function($filter) {
            $filter->expand();
            $filter->disableIdFilter();
            $filter->like('name', trans('admin.week_name'));
        });
        $grid->header(function ($query) {
            return '<i><label>*SNTLD : </label> Số người trả lời đúng</i>';
        });
        $grid->name(trans('admin.week_name'));
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
        $grid->column('number_answers', 'Số lượt trả lời')->display(function () {
            return $this->memberExam->count();
        })->label('primary');
        $grid->column('people_correct', 'SNTLD')->display(function () {
            return $this->countNumberUserCorrect($this->id);
        })->label('success');
        $grid->disableExport(false);
        $grid->actions(function ($grid) {
            $route = route('weeks.answers', $grid->getKey());
            $prize = route('weeks.prizes', $grid->getKey());
            $grid->append('<a data-toggle="tooltip" title="Xoá" class="btn-delete-week cursor-pointer" data-value="'.$grid->getKey().'"><i class="fa fa-trash" aria-hidden="true"></i></a>');
            $grid->prepend('<a href="'.$prize.'" data-toggle="tooltip" title="Danh sách trúng giải"><i class="fa fa-gift" aria-hidden="true"></i></a>');
            $grid->prepend('<a href="'.$route.'" data-toggle="tooltip" title="Danh sách câu trả lời"><i class="fa fa-slack" aria-hidden="true"></i></a> &nbsp;');

        });
        $grid->disableRowSelector();
        Admin::script($this->script());

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id) {
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
    protected function form() {
        $form = new Form(new Week);

        $form->hidden('id', 'ID');
        $form->text('name', 'Tên tuần thi');
        $form->datetime('date_start', 'Ngày bắt đầu');
        $form->datetime('date_end', 'Ngày kết thúc');
        $form->select('status', 'Trạng thái')->options([0 => 'Chưa diễn ra', 1 => 'Đang diễn ra', 2 => 'Đã kết thúc']);
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
     * Store new week
     *
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request) {
        $data = $request->all();
        $week = $this->service->create($data);
        $this->service->createQuestionAndAnswer($week->id, $data);
        $this->service->addPrize($week->id);

        admin_toastr('Lưu thành công', 'success');
        return redirect()->route('weeks.index');
    }

    /**
     * Update a week
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request) {
        $data = $request->all();
        $this->service->update($data);
        $this->service->updateQuestionAndAnswer($data);

        admin_toastr('Lưu thành công', 'success');
        return redirect()->route('weeks.index');
    }

    public function script() {
        $title = trans('admin.export');
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

            $('.btn-delete-week').click(function () {
                let id = $(this).attr('data-value');
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xoá ?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xoá',
                    cancelButtonText: 'Huỷ'
                  }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: 'delete',
                            url: 'weeks/'+id,
                            success: function (response) {
                                window.location.reload();
                            }
                       });
                    }
                  })
            });

            $('.btn-twitter[title="{$title}"]').removeAttr('href');
            $('.btn-twitter[title="{$title}"]').removeAttr('target');

            $('.btn-twitter[title="{$title}"]').click(function (e)  {
                e.preventDefault();
                window.open('weeks/export', '_blank');
            });
        });

EOT;
    }

    public function answers($id, Content $content) {
        return $content
        ->header('Tuần thi trắc nghiệm')
        ->description('Danh sách câu trả lời')
        ->body($this->gridAnswers($id));
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function gridAnswers($id)
    {
        $grid = new Grid(new MemberExam);
        $grid->model()->where('week_id', $id)->orderBy('created_at', 'desc');
        $grid->header(function ($query) use ($id) {
            $week = Week::find($id);
            $number = Week::countNumberUserCorrect($id);
            return '<label> *'.$week->name.' : '.date('H:i - d/m/Y', strtotime($week->date_start)) .' đến '. date('H:i - d/m/Y', strtotime($week->date_end)).'</label>'.
                '<br><i style="color: red">*Số người trả lời đúng câu hỏi : <label> '.$number.'</label></i>';
        });
        $grid->column('member_name', 'Tên')->display(function () {
            return $this->member->name ?? "Đang cập nhật";
        });
        $grid->answer('Câu trả lời')->display(function() {
            if (!is_null($this->answer)) {

                $answer = json_decode($this->answer);
                $html = "";
                $key_ques = 1;
                foreach ($answer as $key => $element) {
                    $question_id = str_replace("question_id_", "", $key);
                    $question = Question::find($question_id);
                    $arr_answers = explode(',', $element);
                    unset($arr_answers[sizeof($arr_answers)-1]);

                    $all_answers = Question::getArrAnswer($question_id);
                    $char = [];
                    if (sizeof($arr_answers) > 0) {
                        foreach ($arr_answers as $row) {
                            $key = array_search((int) $row, $all_answers);
                            $char[] = Question::getArrayString($key);
                        }
                    }

                    $char_str = implode(', ', $char);

                    $html .= "Câu hỏi: ".$key_ques." - Đáp án: $char_str<br>";
                    $key_ques++;
                }
                return $html;
            }

            return null;
        });
        $grid->result('Kết quả')->display(function () {
            return $this->result == 1 ? "<span class='label label-success'>Đúng</span>" : "<span class='label label-danger'>Sai</span>";
        })->filter([
            0 => 'Sai',
            1 => 'Đúng',
        ]);
        $grid->people_number('Dự đoán số người trả lời đúng')->display(function () {
            return number_format(str_replace(',', '', $this->people_number));
        });
        $grid->disableCreateButton();
        $grid->actions(function ($grid) {
            $grid->disableView();
            $grid->disableEdit();
        });

        $grid->tools(function (Grid\Tools $tools) {
            // Add a button, the argument can be a string, or an instance of the object that implements the Renderable or Htmlable interface
            $tools->append('<a class="btn btn-xs btn-warning" onClick="window.history.back();">Quay lại</a>');
        });

        return $grid;
    }

    public function destroy($id) {
        Week::find($id)->delete();
        admin_toastr('Xoá thành công');
        return response()->json([
            'result'    =>  true
        ]);
    }

    public function export() {
        return Excel::download(new WeeksExport, $this->fileExportName);
    }

    public function prizes($id, Content $content) {
        return $content
        ->header('Tuần thi trắc nghiệm')
        ->description('Danh sách trúng giải')
        ->body($this->gridPrizes($id));
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function gridPrizes($id)
    {
        $grid = new Grid(new WeekPrize);
        $grid->model()->where('week_id', $id);

        $grid->order('Số thứ tự');
        $grid->column('prize', 'Giải thưởng')->display(function () {
            $prize = Prize::find($this->prize_id);
            $data  = [
                1   =>  'Giải nhất',
                2   =>  'Giải nhì',
                3   =>  'Giải ba',
                4   =>  'Giải khuyến khích'
            ];
            return $data[$prize->level];
        });
        $grid->column('prize_content', 'Trị giá')->display(function () {
            $prize = Prize::find($this->prize_id);
            return $prize->content;
        });
        $grid->column('member', 'Khách hàng')->display(function () {
            $exam = MemberExam::find($this->member_exam_id);
            if (!is_null($exam)) {
                $route = route('members.show', $exam->member->id);
                return "<a href=".$route." target='_blank'>".$exam->member->name."</a>";
            }
            return null;
        });
        $grid->column('time', 'Thời gian trả lời')->display(function () {
            $exam = MemberExam::find($this->member_exam_id);
            if (!is_null($exam)) {
                return date('H:i:s | d/m/Y', strtotime($exam->created_at));
            }
            return null;
        });
        $grid->disableCreateButton();
        $grid->actions(function ($grid) {
            $grid->disableView();
            $grid->disableEdit();
        });


        $grid->tools(function (Grid\Tools $tools) {
            // Add a button, the argument can be a string, or an instance of the object that implements the Renderable or Htmlable interface
            $tools->append('<a class="btn btn-xs btn-warning" onClick="window.history.back();">Quay lại</a>');
        });

        return $grid;
    }
}
