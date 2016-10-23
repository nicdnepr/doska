<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

<?php

$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id'=>'category-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions' => [
        'class' => 'well'
    ]
));

echo $form->errorSummary($model);

echo $form->textFieldGroup($model, 'code');

echo $form->select2Group($model, 'parent_id', [
    'wrapperHtmlOptions' => [

    ],
    'widgetOptions' => [
        'data' => CHtml::listData(Category::model()->getCategorys(), 'id', 'name'),
        'options' => [
            'allowClear' => true,
            //'placeHolder' => 'Select'
        ],
        'htmlOptions' => [
            'empty' => [
                0 => 'Parent category'
            ]
        ]
    ]
]);

echo $form->textFieldGroup($model, 'name');

echo $form->textFieldGroup($model, 'url');

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