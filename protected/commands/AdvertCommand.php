<?php
/**
 * Created by PhpStorm.
 * User: k
 * Date: 04.03.16
 * Time: 13:27
 */

class AdvertCommand extends CConsoleCommand
{
    public function actionSetUnpaid()
    {
        Yii::app()->db->createCommand('UPDATE Advert Set paid=0 WHERE DATE(expiry_date) < CURDATE()')->execute();
    }

    public function actionFix()
    {
        Yii::app()->db->createCommand('UPDATE Category_Advert Set category_id=124 WHERE category_id=20')->execute();
        Yii::app()->db->createCommand('UPDATE Category_Advert Set category_id=124 WHERE category_id=40')->execute();
        Yii::app()->db->createCommand('UPDATE Category_Advert Set category_id=124 WHERE category_id=41')->execute();
        Yii::app()->db->createCommand('UPDATE Category_Advert Set category_id=124 WHERE category_id=42')->execute();
    }
}