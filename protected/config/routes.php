<?php

return [
    'c/<code:\w+>/<page:\d+>' => 'category/index',
    'c/<code:\w+>' => 'category/index',
    '<page:\d+>' => 'category/index',
    '/' => 'category/index',
    'adv/<id:\d+>/<category>/<subcategory>/<country>/<city>/<title>.html' => 'advert/display',
    'adv/<id:\d+>' => 'advert/display',
    'adverts' => 'advert/index',
    'payments' => 'paylog/index',
    'login' => 'site/login',
    'register' => 'site/register',
    'restore' => 'site/restore',
    '<type:(platinum|silver)>/<url:[-\w]+>' => 'category/paidAdverts',

];