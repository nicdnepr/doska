<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = Yii::app()->name;
Yii::app()->clientScript->registerScriptFile('/js/regions.js');
?>

<h1><?= isset($category) ? $category->name : '' ?></h1>

<div class="col-lg-3">
    <div id="console" class="alert-danger"></div>
    <?php

    $form=$this->beginWidget('booster.widgets.TbActiveForm');

    echo $form->select2Group($geoForm, 'country_id', [
        'wrapperHtmlOptions' => [

        ],
        'widgetOptions' => [
            'options' => [
                'allowClear' => true,
            ],
            'htmlOptions' => [
            ]
        ]
    ]);

    echo $form->select2Group($geoForm, 'region_id', [
        'wrapperHtmlOptions' => [

        ],
        'widgetOptions' => [
            'options' => [
                'allowClear' => true,
            ],
            'htmlOptions' => [
            ]
        ]
    ]);

    ?>

    <div id="sub_region" style="display: none;">
        <?= $form->select2Group($geoForm, 'sub_region_id', [
            'wrapperHtmlOptions' => [

            ],
            'widgetOptions' => [
                'data' => CHtml::listData(SubRegion::model()->findAll(), 'id', 'name'),
                'htmlOptions' => [
                    'empty' => 'None',
                ]
            ]
        ]); ?>
    </div>

    <?php

    $this->widget(
        'booster.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'label' => 'GO',
        ]
    );

    $this->widget(
        'booster.widgets.TbButton',
        [
            'buttonType' => 'button',
            'label' => 'GEO',
            'id' => 'bGeo'
        ]
    );

    $this->endWidget();

    $this->widget('CTreeView', [
        'data'=>$treeViewData,
        'collapsed'=>true,
        'persist'=>'location',
    ]);

    ?>
</div>

<div class="col-lg-9">
    <?php $this->widget('booster.widgets.TbListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'/advert/_view',
        'ajaxUpdate' => false,
        'template'=>'{items} {pager}',
        'emptyText' => ''
    )); ?>
</div>

<script>

    var country_id = '<?= $geoForm->country_id ?>';
    var region_id = '<?= $geoForm->region_id ?>';

    $(function() {

        loadCountries(country_id, region_id);

        $('select[name$="[country_id]"]').change(function() {
            loadRegions($('select[name$="[country_id]"]').val(), '');
        });

        $('select[name$="[region_id]"]').change(function() {
            display_sub_region();
        });

        $('#bGeo').click(function() {
            getLocation();
        });

    });

</script>
