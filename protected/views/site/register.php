<?php

/* @var $model User */
/* @var $this Controller */

$this->pageTitle = 'Register';

?>

<?php if (Yii::app()->user->hasFlash('message')): ?>

    <h3><?= Yii::app()->user->getFlash('message') ?></h3>

<?php else: ?>

    <h1>Registration</h1>

    <div class="form">
        <?php

        $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
            'id'=>'reg-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => [
                'class' => 'well'
            ]
        ));

        echo $form->textFieldGroup($model, 'f_name');
        echo $form->textFieldGroup($model, 'l_name');
        echo $form->emailFieldGroup($model, 'email');
        echo $form->telFieldGroup($model, 'phone', [
            'widgetOptions' => [
                'htmlOptions' => [
                    'autocomplete' => 'tel'
                ]
            ]
        ]);
        echo $form->passwordFieldGroup($model, 'password');
        echo $form->passwordFieldGroup($model, 'password2');

        $this->widget('ReCaptcha', array(
            'model' => $model,
            'attribute' => 'recaptcha',
        ));

        $this->widget(
            'booster.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'label' => 'Register',
            ]
        );

        $this->widget('LoginSocial');

        $this->endWidget();

        ?>
    </div>

<?php endif; ?>