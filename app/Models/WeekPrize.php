<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brazzer\Admin\Traits\AdminBuilder;

class WeekPrize extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "week_prizes";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['week_id', 'prize_id', 'member_exam_id', 'order'];

    public function prizes() {
        return $this->hasMany('App\Models\Prize', 'id', 'prize_id');
    }


}
