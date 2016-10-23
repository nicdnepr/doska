<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
//$this->breadcrumbs=array(
//    'Login',
//);
?>

<h1>Login</h1>

<div class="form">

<?php

    $form=$this->beginWidget('booster.widgets.TbActiveForm', [
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' => [
            'class' => 'well'
        ]
    ]);

    echo $form->textFieldGroup($model, 'username');
    echo $form->passwordFieldGroup($model, 'password');
    echo $form->checkboxGroup($model, 'rememberMe');

    $this->widget(
        'booster.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'label' => 'Login',
        ]
    );


    echo '<br>';
    $this->widget('booster.widgets.TbButton', array(
        'label'=>'Forgot password',
        'buttonType' => 'link',
        'context' => 'link',
        'url'=>['restore'],
    ));
    //echo '</div>';

    $this->widget('LoginSocial');

    $this->endWidget();
?>
</div><!-- form -->

