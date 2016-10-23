<?php
/* @var $this PaylogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Paylogs',
);


?>

<h1>Payments</h1>

<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'paylog-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        //'advert_id',
        [
            'name'=>'advert_id',
            'type'=>'raw',
            'value'=>'CHtml::link($data->advert_id, ["advert/view", "id"=>$data->advert_id])',
        ],
        'amount',
        'description',
        [
            'name' => 'create_time',
            'value' => 'Yii::app()->format->formatDateTime($data->create_time)',
            'htmlOptions'=>[
            ]
        ],
        'token',
    ),
)); ?>
