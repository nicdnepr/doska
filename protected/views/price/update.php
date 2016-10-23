<?php
$this->breadcrumbs=array(
    'Default prices'
);
?>

<?php if (Yii::app()->user->hasFlash('message')): ?>

<div class="alert alert-success">
    <?= Yii::app()->user->getFlash('message') ?>
</div>

<?php endif; ?>

<h1>Default prices (<?= Opay::CURRENCY ?>)</h1>

<div class="form">

    <?php
    $form=$this->beginWidget('booster.widgets.TbActiveForm', [

        'htmlOptions' => [
            'class' => 'well'
        ]
    ]);


    foreach($items as $i=>$item) {
        echo '<div class="form-group">';
        echo CHtml::label($item->name, '', ['class' => 'control-label']);
        echo CHtml::activeTextField($item, "[$i]value", ['class' => 'form-control']);
        echo CHtml::error($item, "[$i]value");
        echo '</div>';
    }

    $this->widget(
        'booster.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'label' => 'Save',
        ]
    );

    $this->endWidget();

    ?>

</div><!-- form -->