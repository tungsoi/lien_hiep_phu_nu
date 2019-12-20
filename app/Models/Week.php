<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brazzer\Admin\Traits\AdminBuilder;

class Week extends Model
{
    use AdminBuilder;
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "weeks";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['name', 'date_start', 'date_end', 'user_id_created', 'status'];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function userCreated() {
        return $this->hasOne('App\User', 'id', 'user_id_created');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function questions() {
        return $this->hasMany('App\Models\Question', 'week_id', 'id');
    }
}
