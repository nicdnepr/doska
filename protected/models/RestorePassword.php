<?php

class RestorePassword extends CFormModel
{
    public $email;

    public function attributeLabels()
    {
        return [
            'email' => 'Enter your email'
        ];
    }

    public function rules()
    {
        return [
            ['email', 'required', 'message'=>'Empty'],
            ['email', 'email', 'message'=>''],
        ];
    }
}