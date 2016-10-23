<?php
/* @var $this PackagePriceController */
/* @var $model PackagePrice */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country_id'); ?>
		<?php echo $form->textField($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'region_id'); ?>
		<?php echo $form->textField($model,'region_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sub_region_id'); ?>
		<?php echo $form->textField($model,'sub_region_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_1'); ?>
		<?php echo $form->textField($model,'price_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_2'); ?>
		<?php echo $form->textField($model,'price_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_3'); ?>
		<?php echo $form->textField($model,'price_3'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->