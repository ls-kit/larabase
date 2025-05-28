<?php
use Illuminate\Support\Str;

return [
    'token' => env('BASEROW_API_TOKEN'),
    'url'   => env('BASEROW_API_URL'),
    'tables' => [
        'courses' => env('COURSES_TABLE_ID'),
        'modules' => env('CUSER_TABLE_ID'),
    ],
    // 'tables' => collect($_ENV)
    //     ->filter(function($value, $key) { return Str::startsWith($key, 'BASEROW_TABLE_'); })
    //     ->mapWithKeys(function($value, $key) {
    //         $name = strtolower(str_replace('BASEROW_TABLE_', '', $key));
    //         return [$name => $value];
    //     })->toArray(),
];