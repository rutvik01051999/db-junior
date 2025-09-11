
<?php

return [
    'HONO_HR_AUTH_URL' => env('HONO_HR_AUTH_URL', 'https://rest.dbclmatrix.com/auth'),
    'HONO_HR_AUTH_TOKEN' => env('HONO_HR_AUTH_TOKEN'),
    
    // Employee Management API Configuration
    'EMPLOYEE_API_URL' => env('EMPLOYEE_API_URL', 'https://mdm.dbcorp.co.in/getEmployees'),
    'EMPLOYEE_API_TOKEN' => env('EMPLOYEE_API_TOKEN', 'Basic TUFUUklYOnVvaT1rai1YZWxGa3JvcGVbUllCXXVu'),
    'EMPLOYEE_API_TIMEOUT' => env('EMPLOYEE_API_TIMEOUT', 15),
    'EMPLOYEE_API_CONNECT_TIMEOUT' => env('EMPLOYEE_API_CONNECT_TIMEOUT', 10),
    'EMPLOYEE_API_RETRY_ATTEMPTS' => env('EMPLOYEE_API_RETRY_ATTEMPTS', 2),
];