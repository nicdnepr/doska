<?php
/* @var $this PackagePriceController */
/* @var $data PackagePrice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('region_id')); ?>:</b>
	<?php echo CHtml::encode($data->region_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_region_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_region_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_1')); ?>:</b>
	<?php echo CHtml::encode($data->price_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_2')); ?>:</b>
	<?php echo CHtml::encode($data->price_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_3')); ?>:</b>
	<?php echo CHtml::encode($data->price_3); ?>
	<br />


</div>