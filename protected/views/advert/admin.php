<?php
/* @var $this AdvertController */
/* @var $model Advert */

$this->breadcrumbs=array(
    'Adverts'
);

$this->menu=array(
    array('label'=>'Create Advert', 'url'=>array('create')),
);

?>

<h1>Manage Adverts</h1>

<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'advert-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'afterAjaxUpdate'=>'function(){
        $("#Advert_user_id").select2({allowClear: true, width:"resolve"});
    }',
    'columns'=>array(
        [
            'class'=>'CButtonColumn'
        ],
        [
            'name' => 'id',
            'htmlOptions'=>[
                'width'=>'1%'
            ]
        ],
        [
            'name'=>'user_id',
            'value'=>'$data->user->email',
            'filter'=>$this->widget('booster.widgets.TbSelect2',
                [
                    'model' => $model,
                    'attribute' => 'user_id',
                    'data' => User::model()->getList(),
                    'options' => [
                        'allowClear' => true,
                        'width' => '100px',
                    ],
                    'htmlOptions' => [
                        'empty' => ''
                    ]
                ],
                true)
        ],
        'name',
        'manager_name',
        'mobile',
        'email',
        'telephone',
        [
            'name'=>'seo1',
            'value'=>'Yii::app()->format->formatBoolean($data->seo1)',
            'filter'=>$model->filter,
            'htmlOptions'=>[
                'width'=>'1%'
            ]
        ],
        [
            'name'=>'seo2',
            'value'=>'Yii::app()->format->formatBoolean($data->seo2)',
            'filter'=>$model->filter,
            'htmlOptions'=>[
                'width'=>'1%'
            ]
        ],
        [
            'name'=>'active',
            'value'=>'Yii::app()->format->formatBoolean($data->active)',
            'filter'=>$model->filter,
            'htmlOptions'=>[
                'width'=>'1%'
            ]
        ],
        [
            'name'=>'paid',
            'value'=>'Yii::app()->format->formatBoolean($data->paid)',
            'filter'=>$model->filter,
            'htmlOptions'=>[
                'width'=>'1%'
            ]
        ],
        [
            'name' => 'start_date',
            'value' => 'Yii::app()->format->formatDate($data->start_date)',
            'htmlOptions'=>[
                'width'=>'6%'
            ]
        ],
        [
            'name' => 'expiry_date',
            'value' => 'Yii::app()->format->formatDate($data->expiry_date)',
            'htmlOptions'=>[
                'width'=>'6%'
            ]
        ],
    ),
)); ?>