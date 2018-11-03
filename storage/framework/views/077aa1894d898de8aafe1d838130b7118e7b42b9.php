<div class="topbar">
    <div class="topbar__wrap pull-center">
        <a href="/">
            <div class="topbar__logo pull-left">
                <div class="topbar__logo-img" src="" alt=""></div>
            </div>
        </a>

        <div class="topbar__nav pull-left">
            <ul class="topbar__nav_wrap">
                <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="topbar__nav_item">
                    <a href="<?php echo e(url('/articles?position_id='.$label->id)); ?>" target="_blank"><?php echo e($label->name); ?></a>
                    <?php if($label->childPositions->count() > 0): ?>
                    <dl class="topbar__nav_item_select">
                    <?php $__currentLoopData = $label->childPositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <dt class="topbar__nav_item_option">
                            <a href="<?php echo e(url('/articles?position_id='.$childLabel->id)); ?>" target="_blank"><?php echo e($childLabel->name); ?></a>
                        </dt>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </dl>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="topbar__info pull-left">
            <ul class="topbar__info_item">
                <li class="topbar__info_login pull-left"><a href="">登录</a></li>
                <li class="topbar__info_register pull-left"><a href="">注册</a></li>
                <li class="topbar__info_national pull-left">
                    全国
                    <ol class="topbar__info_national-city">
                        <li class="topbar__info_national-city_item">北京</li>
                        <li class="topbar__info_national-city_item">上海</li>
                        <li class="topbar__info_national-city_item">深圳</li>
                        <li class="topbar__info_national-city_item">广东</li>
                        <li class="topbar__info_national-city_item">北京</li>
                        <li class="topbar__info_national-city_item">上海</li>
                        <li class="topbar__info_national-city_item">深圳</li>
                        <li class="topbar__info_national-city_item">广东</li>
                    </ol>
                </li>
                <li class="topbar__info_language pull-left">
                    <span class="topbar__info_flag pull-left"></span>
                    <span class="topbar__info_language-select">
                        中文
                        <ol class="topbar__info_language-wrap">
                            <li class="topbar__info_language-item" style="background: url(<?php echo e(asset('front/images/flag_Japanese.png')); ?>) no-repeat center left;">日本语</li>
                            <li class="topbar__info_language-item" style="background: url(<?php echo e(asset('front/images/flag_English.png')); ?>) no-repeat center left;">ENGLISH</li>
                            <li class="topbar__info_language-item" style="background: url(<?php echo e(asset('front/images/flag_Spanish.png')); ?>) no-repeat center left;">Español</li>
                            <li class="topbar__info_language-item" style="background: url(<?php echo e(asset('front/images/flag_French.png')); ?>) no-repeat center left;">Français</li>
                            <li class="topbar__info_language-item" style="background: url(<?php echo e(asset('front/images/flag_Korean.png')); ?>) no-repeat center left;">대한민국</li>
                        </ol>
                    </span>
                </li>
            </ul>
            <p class="topbar__input-wrap pull-right">
                <input class="topbar__input pull-left" type="text" placeholder="输入关键词" value="<?php echo e(app('request')->input('keyword')); ?>">
                <span class="topbar__input-search pull-left"></span>
            </p>
        </div>
    </div>
</div>
