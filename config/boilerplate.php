<?php

return [

    // these options are related to the compute motor premium procedure
    'compute_motor_premium' => [

        // this option must be set to true if you want to release a token
        // when your user successfully terminates the sign-in procedure
        //'release_token' => env('SIGN_UP_RELEASE_TOKEN', false),

        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'vehicle_use' => 'required',
            'vehicle_cover' => 'required',
            'vehicle_risk' => 'required',
            'vehicle_currency' => 'required',
            'vehicle_value' => 'required',
            'vehicle_seating_capacity' => 'required',
            'vehicle_make_year' => 'required',
            'vehicle_buy_back_excess' => 'required',
            'vehicle_tppdl_value' => 'required',
            'vehicle_cubic_capacity' => 'required'
        ]
    ],

    // these options are related to the load risk procedure
    'loadrisk' => [

        // this option must be set to true if you want to release a token
        // when your user successfully terminates the sign-in procedure
        //'release_token' => env('SIGN_UP_RELEASE_TOKEN', false),

        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'vehicle_use' => 'required'
        ]
    ],

    // these options are related to the sign-up procedure
    'sign_up' => [

        // this option must be set to true if you want to release a token
        // when your user successfully terminates the sign-in procedure
        'release_token' => env('SIGN_UP_RELEASE_TOKEN', false),

        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    // these options are related to the login procedure
    'login' => [

        // here you can specify some validation rules for your login request
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    // these options are related to the password recovery procedure
    'forgot_password' => [

        // here you can specify some validation rules for your password recovery procedure
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    // these options are related to the password recovery procedure
    'reset_password' => [

        // this option must be set to true if you want to release a token
        // when your user successfully terminates the password reset procedure
        'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),

        // here you can specify some validation rules for your password recovery procedure
        'validation_rules' => [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ]

];
