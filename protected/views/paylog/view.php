<?php
/* @var $this PaylogController */
/* @var $model Paylog */

$this->breadcrumbs=array(
	'Paylogs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Paylog', 'url'=>array('index')),
	array('label'=>'Create Paylog', 'url'=>array('create')),
	array('label'=>'Update Paylog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Paylog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Paylog', 'url'=>array('admin')),
);
?>

<h1>View Paylog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'advert_id',
		'amount',
		'create_time',
	),
)); ?>
