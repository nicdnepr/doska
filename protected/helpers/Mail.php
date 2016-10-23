<?php

class Mail
{
    public static function send($to, $subject, $body)
    {
        $params = Yii::app()->params->mailer;

        if ($params['transport'] === 'sendmail') {
            $transport = Swift_SendmailTransport::newInstance('sendmail -bs');
        } elseif ($params['transport'] === 'smtp') {
            $transport = Swift_SmtpTransport::newInstance($params['server'], $params['port'])
                ->setUsername($params['user'])
                ->setPassword($params['password'])
            ;
        } else {
            throw new Exception('Transport config not set');
        }

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance($subject)
            ->setFrom($params['from'])
            ->setTo($to)
            ->setBody($body, 'text/html', 'utf-8');

        if (!$mailer->send($message)) {
            throw new Exception('Can\'t send email');
        }
    }

    public static function prepare($view, $advert_id, $user_id)
    {

        $user = User::model()->findByPk($user_id);
        $advert = Advert::model()->findByPk($advert_id);

        $name = isset($advert) ? $advert->name : '';

        $subjects = [
            'signups' => [
                'user'  => 'Welcome to ' . Yii::app()->params->hostName,
                'admin' => 'New user ' . $user->email
            ],
            'payments' =>  [
                'user'  => 'Payment received',
                'admin' => 'Payment from user ' . $user->email
            ],
            'create' => [
                'user'  => "Pending Payment: Advert Company1",
                'admin' => "Review advert {$name}"
            ],
            'live' => [
                'user'  => "Advert {$name} is live",
                'admin' => "Advert {$name} is live"
            ],
        ];


        $items = [
            'user'  => $user->email,
            'admin' => $view . '@' . Yii::app()->params->hostName
        ];

        foreach ($items as $key=>$email) {

            if ( ('create' == $view || 'live' == $view) && 1 == $user_id && 'user' == $key) {
                continue;
            }

            $body = Yii::app()->controller->renderPartial(
                "/emails/{$key}/{$view}",
                [
                    'user'   => $user,
                    'advert' => $advert
                ],
                true
            );

            try {
                self::send($email, $subjects[$view][$key], $body);
            } catch (CException $ex) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
    }
}