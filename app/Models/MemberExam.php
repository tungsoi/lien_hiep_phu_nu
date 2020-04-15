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
    protected $fillable = ['user_id', 'week_id', 'answer', 'people_number', 'result', 'sub'];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function member() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
