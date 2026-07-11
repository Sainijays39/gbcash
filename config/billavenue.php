<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | "uat" (staging) or "live" (production). Determines which base URL is used.
    |
    */

    'environment' => env('BILLAVENUE_ENV', 'uat'),

    'base_urls' => [
        'uat' => 'https://stgapi.billavenue.com/billpay',
        'live' => 'https://api.billavenue.com/billpay',
    ],

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | Provided by BillAvenue after Agent Institution (AI) onboarding.
    | instituteId defaults to agent_id if BillAvenue only issued a single code —
    | confirm with BillAvenue support if bill-fetch/pay calls reject it.
    |
    */

    'agent_id' => env('BILLAVENUE_AGENT_ID'),
    'access_code' => env('BILLAVENUE_ACCESS_CODE'),
    'working_key' => env('BILLAVENUE_WORKING_KEY'),
    'institute_id' => env('BILLAVENUE_INSTITUTE_ID', env('BILLAVENUE_AGENT_ID')),

    /*
    |--------------------------------------------------------------------------
    | API version + timeout
    |--------------------------------------------------------------------------
    */

    'api_version' => '1.0',
    'timeout' => 60,

    /*
    |--------------------------------------------------------------------------
    | Device info sent with every request (BBPS requires this, though it need
    | not reflect a literal physical device for a server-side integration)
    |--------------------------------------------------------------------------
    */

    'device' => [
        'init_channel' => 'AGT',
        'ip' => '127.0.0.1',
        'mac' => '00-00-00-00-00-00',
    ],
];
