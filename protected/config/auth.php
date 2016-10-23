<?php

return array(
    'updateAdvert' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Update advert',
        'children' => array(),
        'bizRule' => null,
        'data' => null
    ),
    'accessOwnAdvert' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Access own advert',
        'children' => [
            'updateAdvert'
        ],
        'bizRule' => 'return Yii::app()->user->id===$params["advert"]->user_id;',
        'data' => null
    ),
    User::ROLE_USER => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'accessOwnAdvert',
        ),
        'bizRule' => null,
        'data' => null
    ),
    User::ROLE_ADMIN => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'updateAdvert',
            User::ROLE_USER
        ),
        'bizRule' => null,
        'data' => null
    ),
);