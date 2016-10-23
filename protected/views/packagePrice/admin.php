<?php
/* @var $this PackagePriceController */
/* @var $model PackagePrice */

$this->breadcrumbs=array(
    'Prices'
);

$this->menu=array(
    array('label'=>'Create', 'url'=>array('create')),
);

?>

<h1>Prices (<?= Opay::CURRENCY ?>)</h1>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'package-price-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'afterAjaxUpdate'=>'function(){
        $("#PackagePrice_country_id").select2({allowClear: true, width:"resolve"});
    }',
    'columns'=>array(
        [
            'name' => 'country_id',
            'value' => '$data->country_name',
            'filter'=>$this->widget('booster.widgets.TbSelect2',
                [
                    'model' => $model,
                    'attribute' => 'country_id',
                    'data' => Geo::getCountries(),
                    'options' => [
                        'allowClear' => true,
                    ],
                    'htmlOptions' => [
                        'empty' => ''
                    ]
                ],
                true)
        ],
        [
            'name' => 'region_name',
            'filter' => false
        ],
        [
            'name' => 'sub_region_id',
            'value' => '$data->sub_region_id ? $data->subRegion->name : "none"',
            'filter' => false
        ],
        [
            'name' => 'price_1',
            'htmlOptions' => [
                'width' => '7%'
            ]
        ],
        [
            'name' => 'price_2',
            'htmlOptions' => [
                'width' => '7%'
            ]
        ],
        [
            'name' => 'price_3',
            'htmlOptions' => [
                'width' => '7%'
            ]
        ],
        [
            'header' => 'Count',
            'value' => 'Advert::model()->countByAttributes(["country_id" => $data->country_id, "region_id" => $data->region_id, "sub_region_id" => $data->sub_region_id])'
        ],
        [
            'class'=>'CButtonColumn',
            'template' => '{update}'
        ],
    ),
)); ?>
