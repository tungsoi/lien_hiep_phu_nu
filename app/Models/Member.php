<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Brazzer\Admin\Traits\AdminBuilder;

class Member extends Model implements AuthenticatableContract
{
    use Authenticatable, AdminBuilder;

    protected $guard = 'member';

    /**
     * Table
     *
     * @var string
     */
    protected $table = "members";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['mobile_phone', 'name', 'birthday', 'password', 'otp', 'gender'];
}
