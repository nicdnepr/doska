<?php

class HybridAuthIdentity extends CBaseUserIdentity
{
    private $_id;

    public function __construct($email)
    {
        $user = User::model()->findByAttributes(['email'=>$email]);

        if (!$user) {
            throw new CHttpException(404);
        }

        $this->_id = $user->id;
        $this->errorCode = self::ERROR_NONE;
    }
    
    public function authenticate()
    {
        throw new CException('Do not call ' . __FUNCTION__);
    }

    public function getId()
    {
        return $this->_id;
    }
}