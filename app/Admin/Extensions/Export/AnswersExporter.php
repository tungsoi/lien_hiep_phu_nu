<?php

Namespace App\Admin\Extensions\Export;

Use Brazzer\Admin\Grid\Exporters\ExcelExporter;

class AnswersExporter extends ExcelExporter
{
    public $type = "queue";
    protected $fileName = 'Article list.xlsx';

    protected $columns = [
        'id' => 'ID',
        'title' => 'title',
        'content' => 'content',
    ];

    protected $headings = ['ID', 'title', 'content'];
}
