<?php

return [

    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'confirmed' => 'The :attribute confirmation does not match.',
    'regex' => 'The :attribute format is invalid.',

    'custom' => [
        'password' => [
            'regex' => 'Password must contain uppercase, lowercase, number, and one special character (@$!%*#?&).',
        ],
    ],
];
