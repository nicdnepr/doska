<?php

class UserInitCommand extends CConsoleCommand
{

    public function actionAdd2()
    {
        Yii::app()->db->createCommand()->insert('User',[
            'email'=>'admin-blue2',
            'hash'=>CPasswordHelper::hashPassword(''),
            'role'=>User::ROLE_ADMIN,
            'create_time'=>new CDbExpression('NOW()')
        ]);
        echo "done\n";
    }

    public function actionEdit()
    {
        $user = User::model()->findByPk(57);
        $user->hash = CPasswordHelper::hashPassword('');
        $user->save(false);
        echo "done\n";
    }
}