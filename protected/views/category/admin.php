<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
    'Categories'
);

$this->menu=array(
    //array('label'=>'List Category', 'url'=>array('index')),
    array('label'=>'Create Category', 'url'=>array('create')),
);

?>

<h1>Manage Categories</h1>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'category-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'code',
        [
            'name'=>'parent_id',
            'value'=>'$data->parent ? $data->parent->name : null',
            'filter'=>CArray::merge(
                [
                    0 => 'Parent'
                ],
                CHtml::listData(Category::model()->getCategorys(), 'id', 'name')
            )
        ],
        'name',
        'url',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}'
        ),
    ),
)); ?>
