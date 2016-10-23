<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Update ' . $model->getName(),
);

?>

<h1>User <?= $model->getName() ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>