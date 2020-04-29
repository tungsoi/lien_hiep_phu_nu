<?php

namespace App\Member\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Week;
use App\Models\MemberExam;
use Brazzer\Admin\Controllers\HasResourceActions;
use Brazzer\Admin\Form;
use Brazzer\Admin\Grid;
use Brazzer\Admin\Layout\Content;
use Brazzer\Admin\Show;
use App\Models\Member;
use App\Admin\Services\WeekService;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Show view dashboard
     *
     * @return void
     */
    public function dashboard() {
        $member = Auth::user() ?? null;
        $week = Week::where('status', 1)->orderBy('date_start', 'asc')->first();
        return view('member.dashboard', compact('week', 'member'));
    }

    /**
     * Detail exam
     *
     * @param [type] $id
     * @return void
     */
    public function exam($id) {
        $week = Week::find($id);
        if (! Auth::user()) {
            return redirect()->route('member.dashboard');
        }

        if ($week == null) {
            return redirect()->route('member.dashboard');
        }

        $order = $this->getArrayString();
        $member = Auth::user();

        return view('member.exam', compact('week', 'order', 'member'));
    }

    /**
     * Store exam
     *
     * @param Request $r
     * @return void
     */
    public function storeExam(Request $request) {
        $data = $request->all();

        $validator = $this->examValidator($data);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data['answer'] = json_encode($data['question']);
        $data['result'] = WeekService::checkResultAnswer($data['question']);
        $data['people_number'] = str_replace(",", "", $data['people_number']);
        unset($data['_token']);
        unset($data['question']);

        MemberExam::firstOrCreate($data);

        session()->flash('send-exam', 'Gửi câu trả lời thành công');
        return redirect()->route('member.dashboard');
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function examValidator(array $data)
    {
        return Validator::make($data, [
            'people_number'        => 'required',
        ]);
    }

    /**
     * Change number to charracter
     *
     * @return void
     */
    public function getArrayString() {
        return [
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
    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Khách dự thi')
            ->description('Danh sách')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Member);

        $grid->name(trans('admin.name'))->editable();
        $grid->mobile_phone(trans('admin.mobile'));
        $grid->birthday(trans('admin.birthday'));
        $grid->gender(trans('admin.gender'))->display(function ($gender) {
            switch($gender) {
                case 0: return trans('admin.female');
                case 1: return trans('admin.male');
                case 2: return trans('admin.other');
                default: return null;
            }
        })->label();

        $grid->created_at('Ngày đăng ký')->display(function ($created_at) {
            return date('H:i - d/m/Y', strtotime($created_at));
        });

        return $grid;
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
            ->header('Khách dự thi')
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
            ->header('Khách dự thi')
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
            ->header('Khách dự thi')
            ->description('Tạo mới')
            ->body($this->form());
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Member::findOrFail($id));

        $show->id('ID');
        $show->name(trans('admin.name'));
        $show->mobile_phone(trans('admin.mobile'));
        $show->birthday(trans('admin.birthday'));
        $show->gender(trans('admin.gender'))->as(function ($gender) {
            switch($gender) {
                case 0: return trans('admin.female');
                case 1: return trans('admin.male');
                case 2: return trans('admin.other');
                default: return null;
            }
        })->label();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Member);

        $form->text('name', trans('admin.name'))->rules(['required'], [
            'required'  =>  trans('admin.place_holder_name')
        ]);

        $form->text('mobile_phone', trans('admin.mobile'))->rules(['required', 'unique:members'], [
            'required'  =>  trans('admin.place_holder_mobile_phone'),
            'unique'    =>  'Số điện thoại này đã được sử dụng'
        ]);
        $form->date('birthday', trans('admin.birthday'))->rules(['required'], [
            'required'  =>  trans('admin.place_holder_birthday')
        ]);

        $gender  = [
            0   =>  trans('admin.female'),
            1   =>  trans('admin.male'),
            2   =>  trans('admin.other')
        ];
        $form->select('gender', trans('admin.gender'))->options($gender)->default(0);
        $form->password('password')->rules(['required'], [
            'required'  =>  trans('admin.place_holder_password')
        ]);

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        return $form;
    }
}
