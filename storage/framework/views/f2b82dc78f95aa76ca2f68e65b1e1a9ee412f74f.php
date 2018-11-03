<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>中华文化走出去网 - 首页</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="/front/css/reset.css?1122">
    <link rel="stylesheet" href="/front/css/swiper.min.css?1122">
    <link rel="stylesheet" href="/front/css/common.css?201810221713">
    
    <?php echo $__env->yieldContent('style'); ?>
    <!--[if IE]>
        <script src="./js/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- S 网站公共头部 -->
    <?php echo $__env->make('frontend.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- E 网站公共头部 -->

    <!-- S 网站主体部分 -->
    <div class="main">
    <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!-- E 网站主体部分 -->

    <!-- S 网站公共尾部 -->
    <?php echo $__env->make('frontend.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- E 网站公共尾部 -->

    <!-- S 右侧快捷功能 -->
    <ul class="menu">
        <!--<li class="menu__item menu__item_sweep"></li>-->
        <li class="menu__item menu__item_star"></li>
        <li class="menu__item menu__item_top"></li>
    </ul>
    <!-- E 右侧快捷功能 -->
</body>
<?php echo $__env->yieldPushContent('before-scripts'); ?>
<script src="/front/js/jquery-1.8.3.js"></script>
<script src="/front/js/swiper.min.js"></script>
<script src="/front/js/common.js?xxxx"></script>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldPushContent('after-scripts'); ?>

</html>
