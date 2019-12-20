<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberExam extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "member_exams";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['member_id', 'week_id', 'answer', 'people_number'];
}
