<?php

$this->breadcrumbs=array(
	'Price'
);

?>

<h1>Price in <?= Opay::CURRENCY ?></h1>

<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'price-grid',
	'dataProvider'=>$dataProvider,
	'hideHeader'=>true,
	'template' => '{items}',
	'columns'=>array(
		'name',
		'value'
	),
)); ?>