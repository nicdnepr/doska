<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="google-site-verification" content="5VQyEmjZ05IOnpPqROXPOO7C-yHigs3emnCjucQ8B4c" />
    <meta name="keywords" content="<?= $this->seo_keywords ?>">
    <meta name="description" content="<?= $this->seo_description ?>">


    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo">
            <div class="row">
                <div class="col-lg-9">

                </div>
                <div class="col-lg-1">
                    <img src="/images/logo.png" >
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>




        </div>
        
    </div><!-- header -->

    <div id="mainMbMenu">
        <?php $this->widget('booster.widgets.TbNavbar', [
            'brand' => false,
            'fixed' => false,
            'items' => [
                [
                    'class' => 'booster.widgets.TbMenu',
                    'type' => 'navbar',
                    'items'=>Menu::items(),
                ],
                $this->renderPartial('//layouts/_search', null, true)
            ]
        ]); ?>
    </div><!-- mainmenu -->
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('booster.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php $this->widget('booster.widgets.TbAlert'); ?>

    <?php echo $content; ?>

    <div style="clear: both;"></div>

    <div id="footer">
        Copyright &copy;<br/>
        All Rights Reserved.
    </div><!-- footer -->

</div><!-- page -->

<script type="text/javascript">
adroll_adv_id = "OIJ5NEBLUJH2JCBNQDMU42";
adroll_pix_id = "W672VBJBHZBHZPS6676VFX";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute('async', 'true');
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName('head') || [null])[0] ||
    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-60280481-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>
