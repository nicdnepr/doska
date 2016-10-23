<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <div class="">
            <?php

            $this->widget('booster.widgets.TbMenu', array(
                'items'=>$this->menu,
                'type' => 'pills'
                //'htmlOptions'=>array('class'=>'operations'),
            ));

            ?>
    </div>

    <div class="">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>


<?php $this->endContent(); ?>