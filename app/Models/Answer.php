<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brazzer\Admin\Traits\AdminBuilder;

class Answer extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "answers";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['question_id', 'is_correct', 'content'];
}
