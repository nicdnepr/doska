<?php
/* @var $this AdvertController */
/* @var $model Advert */

$this->breadcrumbs=array(
    //'Adverts'=>array('index'),
    $model->name,
);

$this->seo_keywords = $model->seo_keywords;
$this->seo_description = $model->seo_description;
?>

<h1><?= CHtml::encode($model->getSeoName()) ?></h1>

<?= ($prev = $model->prev) ? $prev->getSeoLink('< Prev') : '' ?>

<?= ($next = $model->next) ? $next->getSeoLink('Next >') : '' ?>

<?php $this->widget('booster.widgets.TbDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        [
            'name'    => 'image',
            'type'    => 'raw',
            'value'   => CHtml::image($model->image, $model->name, ['title' => $model->name]),
            'visible' => !empty($model->image)
        ],
        'name',
        'address',
        'postcode',
        [
            'name'  => 'description',
            'type'  => 'raw',
            'value' => nl2br(CHtml::encode($model->description))
        ],
    ),
)); ?>

<div class="col-lg-12">

    <?php

    if (!empty($model->email)) {
        echo CHtml::mailto(CHtml::image('/images/email.png'), $model->email, ['rel' => 'nofollow']);
    }

    if (!empty($model->telephone)) {
        echo CHtml::link(CHtml::image('/images/phone.png'), 'tel:'.$model->telephone, ['rel' => 'nofollow']);
    }

    if (!empty($model->web)) {
        echo CHtml::link(CHtml::image('/images/web.png'), $model->web, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    if (!empty($model->facebook_url)) {
        echo CHtml::link(CHtml::image('/images/facebook.png'), $model->facebook_url, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    if (!empty($model->twitter_url)) {
        echo CHtml::link(CHtml::image('/images/twitter.png'), $model->twitter_url, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    if (!empty($model->instagram_url)) {
        echo CHtml::link(CHtml::image('/images/instagram.png'), $model->instagram_url, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    if (!empty($model->gplus_url)) {
        echo CHtml::link(CHtml::image('/images/gplus.png'), $model->gplus_url, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    if (!empty($model->youtube_url)) {
        echo CHtml::link(CHtml::image('/images/youtube.png'), $model->youtube_url, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    if (!empty($model->pinterest_url)) {
        echo CHtml::link(CHtml::image('/images/pinterest.png'), $model->pinterest_url, ['rel' => 'nofollow', 'target' => '_blank']);
    }

    ?>

</div>

<?php $this->widget('application.widgets.stripe.StripeWidget', [
    'advert' => $model
]);
