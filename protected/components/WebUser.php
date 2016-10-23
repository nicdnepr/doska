<?php

class WebUser extends CWebUser {

    private $_model = null;
 
    function getRole() {
        if($user = $this->getModel()){
            return $user->role;
        }
    }

    function getDiscount() {
        if($user = $this->getModel()){
            return $user->discount;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role, discount'));
        }
        return $this->_model;
    }
}
