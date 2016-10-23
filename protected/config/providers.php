<?php

return array(
    "base_url" => Yii::app()->controller->createAbsoluteUrl('site/login'),
    "providers" => array(

        "Facebook" => array (
            "enabled" => true,
            "keys" => array (
                "id"     => "",
                "secret" => "",
            ),
            "scope" => "email"
        ),
    ),
    // If you want to enable logging, set 'debug_mode' to true.
    // You can also set it to
    // - "error" To log only error messages. Useful in production
    // - "info" To log info and error messages (ignore debug messages)
    "debug_mode" => 'error',
    // Path to file writable by the web server. Required if 'debug_mode' is not false
    "debug_file" => Yii::app()->runtimePath . '/fb.log',
);