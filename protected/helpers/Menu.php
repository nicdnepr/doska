<?php

class Menu
{
    public static function items()
    {

        $menu = [
            ['label' => 'Home', 'url' => ''],
            ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::app()->user->isGuest],
            ['label' => 'Register', 'url' => ['site/register'], 'visible' => Yii::app()->user->isGuest]
        ];

        $menu[] = [
            'label' => 'Directory',
            'url' => ['category/index']
        ];

        if (Yii::app()->user->role == User::ROLE_USER) {

            $menu = CMap::mergeArray($menu, [
                ['label' => 'Adverts', 'url' => ['advert/index']],
                ['label' => 'Payments', 'url' => ['paylog/index']],
                ['label' => 'Price', 'url' => ['price/index']],
            ]);
            
        } elseif (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) {
            
            $items = [
                ['label' => 'Users', 'url' => ['user/admin']],
                ['label' => 'Category', 'url' => ['category/admin']],
                ['label' => 'Adv', 'url' => ['advert/admin']],
                ['label' => 'Payments', 'url' => ['paylog/admin']],
                ['label' => 'Default prices', 'url' => ['price/update']],
                ['label' => 'Prices', 'url' => ['packagePrice/admin']],
            ];
            
            $menu = CMap::mergeArray($menu, $items);
        }

        $menu[] = [
            'label' => 'Logout',
            'url' => ['site/logout'],
            'visible' => !Yii::app()->user->isGuest
        ];

        return $menu;
    }
}