<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Brazzer\Admin\Controllers\HasResourceActions;
use Brazzer\Admin\Form;
use Brazzer\Admin\Grid;
use Brazzer\Admin\Layout\Content;
use Brazzer\Admin\Show;
use App\User;

class MemberController extends Controller
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
        $grid = new Grid(new User);
        $grid->model()->where('is_member', 1);
        $grid->name(trans('admin.name'))->editable();
        $grid->mobile(trans('admin.mobile'));
        $grid->birthday(trans('admin.birthday'));
        $grid->gender(trans('admin.gender'))->display(function ($gender) {
            switch($gender) {
                case 0: return trans('admin.female');
                case 1: return trans('admin.male');
                case 2: return trans('admin.other');
                default: return null;
            }
        })->label();
        $grid->address(trans('admin.address'));
        $grid->district(trans('admin.district'))->display(function ($district) {
            return District::where('district_id', $this->district)->first()->name ?? "";
        });
        $grid->province(trans('admin.province'))->display(function ($province) {
            return Province::where('province_id',$this->province)->first()->name ?? "";
        });
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
        $show = new Show(User::findOrFail($id));
        $show->name(trans('admin.name'));
        $show->mobile(trans('admin.mobile'));
        $show->birthday(trans('admin.birthday'));
        $show->gender(trans('admin.gender'))->as(function ($gender) {
            switch($gender) {
                case 0: return trans('admin.female');
                case 1: return trans('admin.male');
                case 2: return trans('admin.other');
                default: return null;
            }
        })->label();
        $show->address(trans('admin.address'));
        $show->district(trans('admin.district'))->as(function ($district) {
            return District::where('district_id', $this->district)->first()->name ?? "";
        });
        $show->province(trans('admin.province'))->as    (function ($province) {
            return Province::where('province_id',$this->province)->first()->name ?? "";
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);
        $form->text('name', trans('admin.name'))->rules(['required'], [
            'required'  =>  trans('admin.place_holder_name')
        ]);
        $form->text('mobile', trans('admin.mobile'))->rules(['required', 'unique:members'], [
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
