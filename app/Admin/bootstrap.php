<?php

use App\Admin\Extensions\HasManyNested;
use Brazzer\Admin\Form;
use App\Admin\Extensions\Show\QuestionHaveAnswer;
use Brazzer\Admin\Show;
use Brazzer\Admin\Facades\Admin;

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Brazzer\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Brazzer\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Form::forget(['map', 'editor']);
app('view')->prependNamespace('admin', resource_path('views/admin'));
Admin::favicon('favicon.png');
Admin::disablePjax();

Form::extend('hasManyNested', HasManyNested::class);
Show::extend('question_have_answer', QuestionHaveAnswer::class);


