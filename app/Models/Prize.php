<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brazzer\Admin\Traits\AdminBuilder;

class Prize extends Model
{
    use AdminBuilder;

    /**
     * Table name
     */
    protected $table = "prizes";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['content', 'level', 'number'];
}
