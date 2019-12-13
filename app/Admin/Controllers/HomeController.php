<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Brazzer\Admin\Layout\Content;
use Brazzer\Admin\Layout\Row;
use Brazzer\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->row(function (Row $row) {
                $row->column(3, new InfoBox('New Users', 'users', 'aqua', '/demo/users', '1024'));
                $row->column(3, new InfoBox('New Orders', 'shopping-cart', 'green', '/demo/orders', '150%'));
                $row->column(3, new InfoBox('Articles', 'book', 'yellow', '/demo/articles', '2786'));
                $row->column(3, new InfoBox('Documents', 'file', 'red', '/demo/files', '698726'));
            });
    }
}
