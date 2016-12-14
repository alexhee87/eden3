<?php

/** @var \Illuminate\Validation\Factory $validator */

Validator::extend(
    'valid_password',
    function ($attribute, $value, $parameters)
    {
        return Hash::check( $value, Auth::user()->password );
    }
);


Validator::extend(
    'before_equal',
    function ($attribute, $value, $parameters) {
        return strtotime(Request::input($parameters[0])) >= strtotime($value);
    }
);