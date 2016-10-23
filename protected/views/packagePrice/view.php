<?php
/* @var $this PackagePriceController */
/* @var $model PackagePrice */

$this->breadcrumbs=array(
	'Package Prices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PackagePrice', 'url'=>array('index')),
	array('label'=>'Create PackagePrice', 'url'=>array('create')),
	array('label'=>'Update PackagePrice', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PackagePrice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PackagePrice', 'url'=>array('admin')),
);
?>

<h1>View PackagePrice #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'country_id',
		'region_id',
		'sub_region_id',
		'price_1',
		'price_2',
		'price_3',
	),
)); ?>
