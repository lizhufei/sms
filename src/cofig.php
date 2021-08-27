<?php
return [
    'operator' => env('SMS_OPERATOR', 'qcloud'), //短信运营商
    'app_key' => env('SMS_APP_ID', ''),
    'app_secret' => env('SMS_APP_SECRET', ''),
    'sign_name' => env('SMS_APP_SIGN', '华视视觉'),
    'project_id' => env('SMS_PROJECT_ID', ''),
    'code_template_id' => env('SMS_CODE_TEMPLATE_ID', '764328')
];
