<?php
Yii::app()->clientScript->registerPackage('carousel');
?>

<style>
    .slick-prev:before,
    .slick-next:before
    {
        color: #f8e3ad;
    }
</style>
<div class="col-lg-12">
    <?php $this->widget('booster.widgets.TbListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_paidItem',
        'ajaxUpdate' => false,
        'template'=>'{items}',
    )); ?>
</div>

<script>
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('.items').slick();
    }
</script>
