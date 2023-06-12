<?php

return [
    'merchantId' => env('MIDTRANS_MERCHANT_ID', null),
    'clientKey' => env('MIDTRANS_CLIENT_KEY', null),
    'serverKey' => env('MIDTRANS_SERVER_KEY', null),
    'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),
    'isSanitized' => env('MIDTRANS_IS_SANITIZED', false),
    'is3ds' => env('MIDTRANS_IS_3DS', false),
];
