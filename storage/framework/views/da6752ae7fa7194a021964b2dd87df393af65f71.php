

<!-- S 中国馆文化推荐 -->
<div class="container_right pull-right container_three">
    <ul class="real-time-news__list">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="real-time-news__item margin-top21 clearfix">
            <span class="real-time-news__number pull-left">1</span>
            <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id])); ?> " target="_blank">
                <span class="real-time-news__title-txt pull-right"><?php echo e($item->title); ?></span>
            </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>

<!-- E 中国馆文化推荐 -->
