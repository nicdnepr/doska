<?php
/**
 * Created by PhpStorm.
 * User: k
 * Date: 03.03.16
 * Time: 22:30
 */

class StripeWidget extends CWidget
{
    public $advert = null;

    public function init()
    {
        parent::init();

        if ($this->advert === null) {
            throw new CHttpException(500, 'Empty advert');
        }
    }


    public function run()
    {
        if ($this->advert->paid) {
            return;
        }

        $this->render('stripe', [
            'advert' => $this->advert,
            'publish' => $this->publish()
        ]);
    }

    private function publish()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('https://js.stripe.com/v2/');

        $publish = Yii::app()->assetManager->publish(__DIR__ . '/assets');

        $cs->registerScriptFile($publish . '/js/stripe.js');
        $cs->registerCssFile($publish . '/css/stripe.css');

        return $publish;
    }
}