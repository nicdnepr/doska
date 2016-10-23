<?php
/* @var $this PackagePriceController */
/* @var $model PackagePrice */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile('/js/regions.js');
?>

<div class="form">

<?php

$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id'=>'package-price-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'htmlOptions' => [
        'class' => 'well'
    ],
    'clientOptions' => [
        'validateOnSubmit'=>true
    ]
));

echo $form->select2Group($model, 'country_id', [
    'wrapperHtmlOptions' => [

    ],
    'widgetOptions' => [
        'data' => Geo::getCountries(),
        'htmlOptions' => [
            'empty' => 'Select country',
            'ajax' => [
                'type'=>'POST',
                'url'=>['geo/regions'],
                'beforeSend'=>'function(data) {
                    display_sub_region();
                    $("select[name$=\"[region_id]\"]").html("").select2();
                }',
                'success'=>'function(data) {
                    $("select[name$=\"[region_id]\"]").html(data).select2();
                }'
            ],
        ]
    ]
]);

echo $form->select2Group($model, 'region_id', [
    'wrapperHtmlOptions' => [
        //'onchange' => 'function() {display_sub_region();}'
    ],
    'widgetOptions' => [
        'data' => Geo::getRegions($model->country_id),
        'htmlOptions' => [

        ],
        'events' => [ // обрабатываем события
            'change' => 'js:function() { display_sub_region(); }'
        ]
    ],

]);

?>

<div id="sub_region">
    <?= $form->select2Group($model, 'sub_region_id', [
        'wrapperHtmlOptions' => [

        ],
        'widgetOptions' => [
            'data' => CHtml::listData(SubRegion::model()->findAll(), 'id', 'name'),
            'htmlOptions' => [
                'empty' => 'None',
            ]
        ]
    ]); ?>
</div>

<?php

echo $form->textFieldGroup($model, 'price_1');
echo $form->textFieldGroup($model, 'price_2');
echo $form->textFieldGroup($model, 'price_3');

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
