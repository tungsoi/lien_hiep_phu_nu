<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Week;
use App\Models\MemberExam;
use Brazzer\Admin\Controllers\HasResourceActions;
use Brazzer\Admin\Form;
use Brazzer\Admin\Grid;
use Brazzer\Admin\Layout\Content;
use Brazzer\Admin\Show;
use App\Models\Prize;

use function GuzzleHttp\json_encode;

class PrizeController extends Controller
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
            ->header('Giải thưởng')
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
        $grid = new Grid(new Prize);

        $grid->level('Giải thưởng')->display(function ($gender) {
            switch($gender) {
                case 1: return 'Nhất';
                case 2: return 'Nhì';
                case 3: return 'Ba';
                default: return 'Khuyến khích';
            }
        });

        $grid->content('Nội dung');
        $grid->number('Số giải 1 tuần');

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
            ->header('Giải thưởng')
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
            ->header('Giải thưởng')
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
            ->header('Giải thưởng')
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
        $show = new Show(Prize::findOrFail($id));

        $show->id('ID');
        $show->level('Giải thưởng')->as(function ($gender) {
            switch($gender) {
                case 1: return 'Nhất';
                case 2: return 'Nhì';
                case 3: return 'Ba';
                default: return 'Khuyến khích';
            }
        });
        $show->content('Nội dung');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Prize);

        $gender  = [
            1   =>  'Giải nhất',
            2   =>  'Giải nhì',
            3   =>  'Giải ba',
            4   =>  'Giải khuyến khích'
        ];
        $form->select('level', 'Giải thưởng')->options($gender);
        $form->text('content', 'Nội dung')->rules(['required'], [
            'required'  =>  'Vui lòng nhập nội dung'
        ]);
        $form->number('number', 'Số lượng giải 1 tuần');

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        return $form;
    }
}
