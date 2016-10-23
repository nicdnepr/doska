<?php
/* @var $this PaylogController */
/* @var $model Paylog */

$this->breadcrumbs=array(
    'Paylogs'
);

$this->menu=array(
    array('label'=>'List Paylog', 'url'=>array('index')),
    array('label'=>'Create Paylog', 'url'=>array('create')),
);

?>

<h1>Payments</h1>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'paylog-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'afterAjaxUpdate'=>'function(){
        //$("select").chosen({"allow_single_deselect":true});
        $("#Paylog_user_id").select2({allowClear: true, width:"resolve"});
    }',
    'columns'=>array(
        //'id',
        [
            'name'=>'user_id',
            'value'=>'$data->user->email',
            //'filter'=>CHtml::activeDropDownList($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'email'), ['class'=>'chzn-select','empty'=>''])
            'filter'=>$this->widget('booster.widgets.TbSelect2',
                [
                    'model' => $model,
                    'attribute' => 'user_id',
                    'data' => CHtml::listData(User::model()->findAll(), 'id', 'email'),
                    'options' => [
                        'allowClear' => true,
                    ],
                    'htmlOptions' => [
                        'empty' => ''
                    ]
                ],
                true)
        ],
        [
            'name'=>'advert_id',
            'htmlOptions'=>[
                'width'=>'4%'
            ]
        ],
        [
            'name'=>'amount',
            'htmlOptions'=>[
                'width'=>'4%'
            ]
        ],
        //'advert_id',
        //'amount',
        'description',
        [
            'name' => 'create_time',
            'value' => 'Yii::app()->format->formatDateTime($data->create_time)',
            'htmlOptions'=>[
            ]
        ],
        'token',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>