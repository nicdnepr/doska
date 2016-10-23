<?php
/* @var $this PaylogController */
/* @var $model Paylog */

$this->breadcrumbs=array(
	'Paylogs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Paylog', 'url'=>array('index')),
	array('label'=>'Manage Paylog', 'url'=>array('admin')),
);
?>

<h1>Create Paylog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>