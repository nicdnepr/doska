<?= CHtml::beginForm(['category/index'], 'get', [
    'class' => 'navbar-form pull-right'
]) ?>

<div class="form-group">
    <?= CHtml::searchField('q', Yii::app()->request->getQuery('q'), ['class' => 'form-control']) ?>
</div>

<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>

<?= CHtml::endForm() ?>
