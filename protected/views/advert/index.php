<h1>Advert list</h1>

<?= CHtml::link('Create', ['create'], ['class' => 'btn btn-success']) ?> <br>
<?= CHtml::link('Active', ['index', 'paid' => 1, 'active'=>1]) ?> <br>
<?= CHtml::link('Not paid', ['index', 'paid' => 0]) ?> <br>
<?= CHtml::link('Not active', ['index', 'paid' => 1, 'active'=>0]) ?>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id'=>'advert-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        [
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}'
        ],
        [
            'name'=>'active',
            'value'=>'Yii::app()->format->formatBoolean($data->active)',
        ],
        [
            'name'=>'package',
            'value'=>'$data->getPackage()'
        ],
        [
            'name'=>'paid',
            'type'=>'raw',
            'value'=>' (strtotime($data->expiry_date) > time() && $data->paid) ? "Paid" : CHtml::link("Pay", ["advert/view", "id"=>$data->id])',
        ],
        [
            'name' => 'expiry_date',
            'value' => 'Yii::app()->format->formatDateTime($data->expiry_date)',
            'htmlOptions'=>[
            ]
        ],
        'name',
        'address',
        'postcode',
        'telephone',
        'fax',
    ),
)); ?>