<?php

return [

    'modules'=>array(

    ),

    'components'=>[
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=adverts',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600
        ),
        'cache'=>[
            'class'=>'CFileCache'
        ]
    ],

    'params'=>[
        'cacheTime' => 3600,
        'geoCacheTime' => 30*24*3600
    ]

];