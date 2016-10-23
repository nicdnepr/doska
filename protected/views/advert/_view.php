<?php
/* @var $this AdvertController */
/* @var $data Advert */
?>

<div class="view">

    <div>
        <b><?= $data->getSeoLink(); ?></b>
    </div>

    <div>
        <b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
        <?php echo CHtml::encode($data->address); ?>
    </div>

    <div>
        <b><?php echo CHtml::encode($data->getAttributeLabel('postcode')); ?>:</b>
        <?php echo CHtml::encode($data->postcode); ?>
    </div>

    <div>
        <b><?php echo CHtml::encode($data->getAttributeLabel('telephone')); ?>:</b>
        <?php echo CHtml::encode($data->telephone); ?>
    </div>

    <?php if ($data->web): ?>
    <div>
        <b><?php echo CHtml::encode($data->getAttributeLabel('web')); ?>:</b>
        <?php echo CHtml::link($data->web, $data->web); ?>
    </div>
    <?php endif; ?>

</div>
