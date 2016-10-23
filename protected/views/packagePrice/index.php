<?php
/* @var $this PackagePriceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Package Prices',
);

$this->menu=array(
	array('label'=>'Create PackagePrice', 'url'=>array('create')),
	array('label'=>'Manage PackagePrice', 'url'=>array('admin')),
);
?>

<h1>Package Prices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
