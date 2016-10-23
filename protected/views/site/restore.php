<?php

/* @var $this Controller */

$this->pageTitle = 'Restore password';
?>

<?php if (Yii::app()->user->hasFlash('message')): ?>

    <h3><?= Yii::app()->user->getFlash('message') ?></h3>

<?php else: ?>

    <h1>Restore password</h1>

    <div class="form">

        <?php

        $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
            'id'=>'form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => [
                'class' => 'well'
            ]
        ));

        echo $form->emailFieldGroup($model, 'email');

        $this->widget(
            'booster.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'label' => 'Restore',
            ]
        );

        $this->endWidget();

        ?>
    </div>

<?php endif; ?>