<?php
/* @var $this AdvertController */
/* @var $model Advert */

/*
$this->breadcrumbs=array(
	'Adverts'=>array('index'),
	'Create',
);
*/

$this->menu=array(
	array('label'=>'List Advert', 'url'=>array('index')),
	array('label'=>'Manage Advert', 'url'=>array('admin')),
);
?>

<h1>Create Advert</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>