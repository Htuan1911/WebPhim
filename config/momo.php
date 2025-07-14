<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cấu hình thông tin Momo
    |--------------------------------------------------------------------------
    |
    | Các thông tin lấy từ tài khoản Momo Developer
    | Dùng để ký và gửi yêu cầu thanh toán
    |
    */

    'partner_code' => env('MOMO_PARTNER_CODE', 'MOMOxxx'),
    'access_key'   => env('MOMO_ACCESS_KEY', 'accesskeyxxx'),
    'secret_key'   => env('MOMO_SECRET_KEY', 'secretkeyxxx'),
];
