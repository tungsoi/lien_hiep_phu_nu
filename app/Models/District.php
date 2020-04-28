<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'district_id',
        'name',
        'type',
        'location',
        'province_id'
    ];
}
