<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
    'Users'
);

$this->menu=array(
    array('label'=>'Create User', 'url'=>array('create')),
);

?>

<h1>Manage Users</h1>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'f_name',
        'l_name',
        'email',
        'discount',
        'expiry',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>
