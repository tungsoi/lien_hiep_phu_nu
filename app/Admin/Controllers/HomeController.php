<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Brazzer\Admin\Layout\Content;
use Brazzer\Admin\Layout\Row;
use Brazzer\Admin\Widgets\InfoBox;
use App\Models\Member;
use App\Models\Week;
use App\User;
use App\Models\MemberExam;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->row(function (Row $row) {
                $row->column(4, new InfoBox('Khách dự thi', 'users', 'aqua', route('members.index'), User::where('is_member', 1)->count()));
                $row->column(4, new InfoBox('Tuần thi trắc nghiệm', 'book', 'yellow', route('weeks.index'), Week::all()->count()));
                $row->column(4, new InfoBox('Quản trị viên', 'shopping-cart', 'green', 'admin/auth/users', User::where('is_member', 0)->count()));
            });
    }
}
