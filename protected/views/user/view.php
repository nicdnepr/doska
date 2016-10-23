<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
    $model->getName()
);
?>

<h1>User <?= $model->getName(); ?></h1>

<?php $this->widget('booster.widgets.TbDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'f_name',
        'l_name',
        'email:email',
        'expiry:date',
        [
            'name' => 'phone',
            'type' => 'raw',
            'value' => CHtml::link(CHtml::encode($model->phone), 'tel:'.$model->phone, ['rel' => 'nofollow'])
        ],
        [
            'name' => 'notes',
            'type' => 'raw',
            'value' => nl2br(CHtml::encode($model->notes))
        ],
    ),
)); ?>
