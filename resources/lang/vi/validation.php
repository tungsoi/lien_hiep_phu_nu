<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'required' => 'Vui lòng nhập thông tin',
    'mobile'   =>   [
        'unique'    =>  'Số điện thoại đã được sử dụng'
    ],
    'password'  =>  [
        'min'   =>  'Tối thiểu 6 ký tự',
        'confirmed' =>  'Mật khẩu xác nhận không chính xác'
    ],
    'email' =>  [
        'email' =>  'Email không đúng định dạng'
    ]

];
