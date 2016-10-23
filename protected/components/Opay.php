<?php

use Omnipay\Omnipay;

class Opay extends CComponent
{
    const CURRENCY = 'GBP';

    public $username;
    public $password;
    public $signature;
    public $sandbox;

    private $_omnipay;

    //price for package
    //private $_amtList;

    public function init()
    {
        $this->_omnipay = Omnipay::create('PayPal_Express');
        $this->_omnipay->setUsername($this->username);
        $this->_omnipay->setPassword($this->password);
        $this->_omnipay->setSignature($this->signature);
        $this->_omnipay->setTestMode($this->sandbox);

		/*
        $this->_amtList = [
            Advert::PACKAGE_SILVER   => 220,
            Advert::PACKAGE_GOLD     => 520,
            Advert::PACKAGE_PLATINUM => 1000
        ];
		 * 
		 */

    }

    public function purchase($id)
    {
        $advert = Advert::model()->findByPk($id);

        if (!$advert)
            throw new CHttpException(404);

        $paylog = new Paylog();
        $paylog->user_id = $advert->user_id;
        $paylog->advert_id = $advert->id;
        $paylog->amount = $this->getAmount($advert->package);
        $paylog->description = $advert->payDescription;
        $paylog->save();

        $params = [
            'transactionId' => $paylog->id,
            'amount'        => number_format($paylog->amount, 2, '.', ''),
            'description'   => $advert->payDescription,
            'currency'      => self::CURRENCY,
            'noShipping'    => 1,
            'landingPage'   => 'Login',
            'cancelUrl'     => Yii::app()->controller->createAbsoluteUrl('site/cancel'),
            'returnUrl'     => Yii::app()->controller->createAbsoluteUrl('site/done')
        ];

        Yii::app()->session[__CLASS__ . 'params'] = $params;
        $params['clientIp'] = Yii::app()->request->userHostAddress;

        $request = $this->_omnipay->purchase($params)->send();

        if ($request->isRedirect()) {
            // redirect to offsite payment gateway
            $request->redirect();
        } else {
            // payment failed: display message to customer
            throw new CHttpException(503, $request->getMessage());
        }
    }

    public function completePurchase($token)
    {
        if (!isset(Yii::app()->session[__CLASS__ . 'params']))
            throw new CHttpException(503, 'Problem with payment. ');

        $params = Yii::app()->session[__CLASS__ . 'params'];
        $params['clientIp'] = Yii::app()->request->userHostAddress;

        $request = $this->_omnipay->completePurchase($params)->send();

        if ($request->isSuccessful()) {
            // payment was successful: update database

            $tran = Yii::app()->db->beginTransaction();

            try {

                $paylog = Paylog::model()->findByPk($params['transactionId']);

                if ($paylog->active) {
                    throw new CHttpException(503, 'Payment done');
                }

                $paylog->active = 1;
                $paylog->token = $token;
                $paylog->save();

                $advert = Advert::model()->findByPk($paylog->advert_id);

                if ($advert->paid) {
                    $attr['expiry_date'] = new CDbExpression('DATE_ADD(NOW(), INTERVAL 1 YEAR)');
                } else {
                    $attr['paid'] = 1;
                }
                $attr['update_time'] = new CDbExpression('NOW()');
                $advert->saveAttributes($attr);

                $tran->commit();

                if (!YII_DEBUG) {
                    Mail::prepare('payments', $advert->id, $advert->user_id);
                }


            } catch (CException $ex) {
                $tran->rollback();
                throw $ex;
            }


        }else {
            // payment failed: display message to customer
            throw new CHttpException(503, $request->getMessage());
        }
    }

    private function getAmount($package)
    {
		$price = Price::model()->findByPk($package);
		
        if (!$price) {
            throw new CException('Wrong package');
        }

        return $price->value;
    }
}