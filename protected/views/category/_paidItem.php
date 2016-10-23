<div class="view">

    <div>
        <b><?= CHtml::encode($data->name) ?></b>
    </div>

    <?php if ($data->email): ?>

    <div>
        <b><?= CHtml::mailto($data->email) ?></b>
    </div>

    <?php endif; ?>


    <?php if ($data->telephone): ?>

        <div>
            <?= CHtml::link('call us', 'tel:' . CHtml::encode($data->telephone)) ?>
        </div>

    <?php endif; ?>


    <?php if ($data->mobile): ?>

        <div>
            <?= CHtml::link('call us mobile', 'tel:' . CHtml::encode($data->mobile)) ?>
        </div>

    <?php endif; ?>


    <?php if ($data->web): ?>
        <div>
            <?php echo CHtml::link('site', $data->web); ?>
        </div>
    <?php endif; ?>


    <div>
        <?= nl2br(CHtml::encode($data->description)) ?>
    </div>

</div>
