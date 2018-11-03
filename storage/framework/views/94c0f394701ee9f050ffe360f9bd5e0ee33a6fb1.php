<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="/front/css/list.css?2223111">
    <link rel="stylesheet" href="/front/css/article.css?2223111">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!--顶部banner-->
    <?php if($zggtoutiaoPosition): ?>
        <?php $__currentLoopData = $zggtoutiaoPosition->getData(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="top_banner">
                <h1><a href="<?php echo e(route('frontend.articles.show', ['article' => $val->id, 'position_id'=>$zggtoutiaoPosition->id])); ?>" target="_blank"><?php echo e($val->title); ?></a></h1>
                <p><><?php echo e($val->brief); ?></p>
            </div>
            <div class="top_banner_line"></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <!-- S 内容主体部分 -->
    <div class="container pull-center clearfix container_hwpt">

        <!--中国馆-->
        <h2 class="page-type_navbar pull-center">
        <!-- <span class="page-type_cn"><?php echo e($position->name); ?></span> -->
            <!-- <span class="page-type_en">News</span> -->
            <span class="page-type_cn">中国<em>馆</em><i>China Pavilion</i></span>
        </h2>

        <div class="container_box pull-center clearfix">
            <?php if(isset($zggTimePositionData[0])): ?>
                <div class="container_left pull-left container_one">
                    <a target="_blank" href="<?php echo e(route('frontend.articles.show', ['article' => $zggTimePositionData[0]->id, 'position_id' => $position->id])); ?>">
                        <div class="container_img">
                            <img  src="<?php echo e(img_resize($zggTimePositionData[0]->banner_url, 540, 320)); ?>"     alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
                        </div>
                        <h4 class="container_news-list_title ellipsis"><?php echo e($zggTimePositionData[0]->title); ?></h4><br />
                        <p class="container_content-text"><?php echo e(str_limit($zggTimePositionData[0]->brief, 200)); ?></p>
                    </a>
                </div>
            <?php endif; ?>

            <div class="container_left pull-left container_two">
                <ul class="container_info clearfix">
                    <?php if(isset($zggTimePositionData[1])): ?>
                        <li class="container_content pull-left">
                            <a target="_blank" href="<?php echo e(route('frontend.articles.show', ['article' => $zggTimePositionData[1]->id, 'position_id' => $position->id])); ?>">
                                <div class="container_img">
                                    <img  src="<?php echo e(img_resize($zggTimePositionData[1]->banner_url, 310, 150)); ?>"   alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
                                </div>
                                <h4 class="container_news-list_title"><?php echo e($zggTimePositionData[1]->title); ?></h4>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(isset($zggTimePositionData[2])): ?>
                        <li class="container_content pull-left">
                            <a target="_blank" href="<?php echo e(route('frontend.articles.show', ['article' => $zggTimePositionData[2]->id, 'position_id' => $position->id])); ?>">
                                <div class="container_img">
                                    <img  src="<?php echo e(img_resize($zggTimePositionData[2]->banner_url, 310, 150)); ?>"   alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
                                </div>
                                <h4 class="container_news-list_title"><?php echo e($zggTimePositionData[2]->title); ?></h4>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="container_right pull-right container_three">
                <h3>
                    <span class="cn"><em>什么是</em>中国馆</span>
                    <span class="en">About China Pavilion</span>
                </h3>
                <p>中国传统文化(traditional culture of China)是中华文明演化而汇集成的一种反映民族特质和风貌的民族文化，是民族历史上各种思想文化、观念形态的总体表征，是指居住在中国地域内的中华民族及其祖先所创造的、为中华民族世世代代所继承发展的、具有鲜明民族特色的、历史悠久、内涵博大精深、传统优良的文化。</p>
                <p>简单来说，就是通过不同的文化形态来表示的各种民族文明，风俗，精神的总称。</p>
                <p>简单来说，就是通过不同的文化形态来表示的各种民族文明，风俗，精神的总称。</p>
                <p class="link"><a href="">进入中国馆</a></p>
            </div>
        </div>

        <!--中国文化中心-->
        <h2 class="page-type_navbar pull-center">
            <span class="page-type_cn">中国<em>文化</em>中心<i>Chinese Culture Center</i></span>
            <!-- <span class="page-type_en">News</span> -->
            <a href="" class="link">进入中国文化中心 <em>&gt;</em></a>
        </h2>
        <div class="container_box pull-center clearfix">
            <?php if(isset($zggwhTimePositionData[0])): ?>
            <div class="container_left pull-left container_one">
                <a target="_blank"  href="<?php echo e(route('frontend.articles.show', ['article' => $zggwhTimePositionData[2]->id, 'position_id' => $position->id])); ?>">
                    <div class="container_img">
                        <img  src="<?php echo e(img_resize($zggwhTimePositionData[0]->banner_url, 540, 320)); ?>"   alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'"  >
                    </div>
                    <h4 class="container_news-list_title ellipsis"><?php echo e($zggwhTimePositionData[0]->title); ?></h4><br />
                    <p class="container_content-text"><?php echo e(str_limit($zggwhTimePositionData[0]->brief, 200)); ?></p>
                </a>
            </div>
            <?php endif; ?>
            <div class="container_left pull-left container_two">
                <ul class="container_info clearfix">
                    <?php if(isset($zggwhTimePositionData[1])): ?>
                    <li class="container_content pull-left">
                        <a target="_blank" href="<?php echo e(route('frontend.articles.show', ['article' => $zggwhTimePositionData[1]->id, 'position_id' => $position->id])); ?>">
                            <div class="container_img">
                                <img  src="<?php echo e(img_resize($zggwhTimePositionData[0]->banner_url, 310, 150)); ?>"   alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'"  >
                            </div>
                            <h4 class="container_news-list_title"><?php echo e($zggwhTimePositionData[1]->title); ?></h4>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(isset($zggwhTimePositionData[2])): ?>
                    <li class="container_content pull-left">
                        <a target="_blank" href="<?php echo e(route('frontend.articles.show', ['article' => $zggwhTimePositionData[2]->id, 'position_id' => $position->id])); ?>">
                            <div class="container_img">
                                <img  src="<?php echo e(img_resize($zggwhTimePositionData[2]->banner_url, 310, 150)); ?>"   alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'"  >
                            </div>
                            <h4 class="container_news-list_title"><?php echo e($zggwhTimePositionData[2]->title); ?></h4>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!--中国文化中心新闻列表-->
            <?php echo $zgwhPosition->getBlock(); ?>

            <!--E 中国文化中心新闻列表-->
        </div>

        <!--孔子学院-->
        <div class="container_banner">
            <h2 class="page-type_navbar pull-center">
                <span class="page-type_cn">孔子<em>学院</em><i>Confucius Institute</i></span>
                <a href="" class="link">进入孔子学院 &gt;</a>
            </h2>
            <!--  <img src="/front/v3/images/banner_type4.png" alt=""> -->
        </div>
        <div class="container_center pull-left clearfix container_center1">
            <div class="pull-left container_half">
                <?php $__currentLoopData = $kzxyTimePositionData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($k >=0 && $k<=2): ?>
                    <?php if($k == 0): ?>
                <ul class="container_info clearfix">
                    <li class="container_img pull-left">
                        <a target="_blank"  href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id])); ?>">
                            <img src="https://cici-images.oss-cn-beijing.aliyuncs.com/silkroad/2018-09/23/129959356_15376875328021n.jpg?x-oss-process=image/resize,m_fill,w_181,h_120" alt=""></a>
                    </li>
                    <li class="container_content pull-left">
                        <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
                        <span class="container_content-text"><?php echo e(str_limit($item->brief, 200)); ?></span>
                    </li>
                </ul>
                    <?php else: ?>
                <div class="container_list">
                    <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
                    <span class="container_content-text container_content-text1"><?php echo e(str_limit($item->brief, 200)); ?></span>
                    <span class="container_content-time"><?php echo e($item->published_at->format("Y-m-d")); ?></span>
                </div>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="pull-right container_half">
                <?php $__currentLoopData = $kzxyTimePositionData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($k >=3 && $k<6): ?>
                        <?php if($k == 3): ?>
                            <ul class="container_info clearfix">
                                <li class="container_img pull-left">
                                    <a target="_blank"  href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id])); ?>">
                                        <img src="https://cici-images.oss-cn-beijing.aliyuncs.com/silkroad/2018-09/23/129959356_15376875328021n.jpg?x-oss-process=image/resize,m_fill,w_181,h_120" alt=""></a>
                                </li>
                                <li class="container_content pull-left">
                                    <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
                                    <span class="container_content-text"><?php echo e(str_limit($item->brief, 200)); ?></span>
                                </li>
                            </ul>
                        <?php else: ?>
                            <div class="container_list">
                                <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
                                <span class="container_content-text container_content-text1"><?php echo e(str_limit($item->brief, 200)); ?></span>
                                <span class="container_content-time"><?php echo e($item->published_at->format("Y-m-d")); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!--对外交流机构-->
        <div class="container_center pull-left clearfix container_center2">
            <div class="container_tit">
                <h3>对外交流机构</h3>
                <span>Foreign Exchange Agencies</span>
            </div>
            <div class="pull-left container_half">
                <?php $__currentLoopData = $dwjlTimePositionData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($k <3): ?>

                <ul class="container_info clearfix">
                    <li class="container_img pull-left">
                        <a  href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id])); ?> ">
                            <img src="https://cici-images.oss-cn-beijing.aliyuncs.com/silkroad/2018-09/23/129959356_15376875328021n.jpg?x-oss-process=image/resize,m_fill,w_110,h_110" alt=""></a>
                    </li>
                    <li class="container_content pull-left">
                        <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
                        <span class="container_content-text"><?php echo e(str_limit($item->brief, 100)); ?></span>
                    </li>
                </ul>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="pull-right container_half">

                <?php $__currentLoopData = $dwjlTimePositionData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($k >=3 && $k<6 ): ?>
                        <ul class="container_info clearfix">
                            <li class="container_img pull-left">
                                <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id])); ?> ">
                                    <img src="https://cici-images.oss-cn-beijing.aliyuncs.com/silkroad/2018-09/23/129959356_15376875328021n.jpg?x-oss-process=image/resize,m_fill,w_110,h_110" alt=""></a>
                            </li>
                            <li class="container_content pull-left">
                                <h4 class="container_news-list_title ellipsis">
                                    <?php echo e($item->title); ?>

                                </h4>
                                <span class="container_content-text"><?php echo e(str_limit($item->brief, 100)); ?></span>
                            </li>
                        </ul>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="list_name">
                <a href="http://www.ccdi.gov.cn/" target="_blank">
                    <li class="im-links__item">中央纪委</li>
                </a>
                <a href="http://www.zgg.gov.cn/" target="_blank">
                    <li class="im-links__item">紫光阁</li>
                </a>
                <a href="http://www.idcpc.org.cn/" target="_blank">
                    <li class="im-links__item">中联部</li>
                </a>
                <a href="http://www.zytzb.org.cn/" target="_blank">
                    <li class="im-links__item">统战部</li>
                </a>
                <a href="http://www.scopsr.gov.cn/" target="_blank">
                    <li class="im-links__item">中编办</li>
                </a>
                <a href="http://www.scio.gov.cn/" target="_blank">
                    <li class="im-links__item">新闻办</li>
                </a>
                <a href="http://www.locpg.hk/index.htm" target="_blank">
                    <li class="im-links__item">香港中联办</li>
                </a>
                <a href="http://www.zlb.gov.cn/index.htm" target="_blank">
                    <li class="im-links__item">澳门中联办</li>
                </a>
                <a href="http://www.cflac.org.cn/" target="_blank">
                    <li class="im-links__item">中国文联</li>
                </a>
                <a href="http://www.tibet.cn/" target="_blank">
                    <li class="im-links__item">中国西藏网</li>
                </a>
                <a href="http://rencai.people.com.cn/" target="_blank">
                    <li class="im-links__item">中国人才网</li>
                </a>
                <a href="http://www.people.com.cn/" target="_blank">
                    <li class="im-links__item">人民网</li>
                </a>
                <a href="http://www.china.com.cn/" target="_blank">
                    <li class="im-links__item">中国网</li>
                </a>
                <a href="http://www.cntv.cn/" target="_blank">
                    <li class="im-links__item">CNTV</li>
                </a>
                <a href="http://www.chinadaily.com.cn/" target="_blank">
                    <li class="im-links__item">中国日报</li>
                </a>
                <a href="http://www.cri.cn/" target="_blank">
                    <li class="im-links__item">国际在线</li>
                </a>
                <a href="http://www.youth.cn/" target="_blank">
                    <li class="im-links__item">中青网</li>
                </a>
                <a href="http://www.ce.cn/" target="_blank">
                    <li class="im-links__item">中经网</li>
                </a>
                <a href="http://www.taiwan.cn/" target="_blank">
                    <li class="im-links__item">中国台湾网</li>
                </a>
                <a href="http://www.cnr.cn/" target="_blank">
                    <li class="im-links__item">央广网</li>
                </a>
                <!--         <a href="http://www.gmw.cn/" target="_blank">
                            <li class="im-links__item">中央纪委20</li>
                        </a> -->
                <a href="http://www.gmw.cn/" target="_blank">
                    <li class="im-links__item">光明网</li>
                </a>
                <a href="http://www.chinanews.com/" target="_blank">
                    <li class="im-links__item">中新网</li>
                </a>
                <a href="http://www.gov.cn/index.htm" target="_blank">
                    <li class="im-links__item">中国政府网</li>
                </a>
            </div>

        </div>

    <!-- <div class="container_left pull-left">
        <?php if($list->count() == 0): ?>
        <div class="container_news-list_empty">暂无信息</div>
        <?php else: ?>
        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="container_news-list">
                <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id])); ?>" target="_blank">
                <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
            </a>
            <ul class="container_info clearfix">

                <?php if($item->coversNum == 0): ?>
                <li class="container_content pull-left" style="width:100%;">
                    <span class="container_content-text"><?php echo e($item->brief); ?></span>
                    <span class="container_content-time"><?php echo e($item->source); ?> <?php echo e($item->published_at->format("Y-m-d")); ?></span>
                </li>
                <?php elseif($item->coversNUm >= 1): ?>
                <div class="container_news-list">
                    <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id])); ?>">
                        <h4 class="container_news-list_title ellipsis"><?php echo e($item->title); ?></h4>
                    </a>
                    <ul class="container_info clearfix">

                        <?php if($item->type == 2): ?>
                    <?php $__currentLoopData = $item->atlas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uidx => $atlas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($uidx > 3): ?>
                            <?php break; ?>
                        <?php endif; ?>
                                <li class="container_img pull-left">
                                    <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id])); ?>"><img src="<?php echo e(img_resize($atlas->banner, 181,120)); ?>" alt=""></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <?php $__currentLoopData = $item->coversUrl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uidx => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($uidx > 0): ?>
                            <?php break; ?>
                        <?php endif; ?>
                                <li class="container_img pull-left">
                                    <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id])); ?>"><img src="<?php echo e(img_resize($url,181,120)); ?>" alt=""></a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="container_content pull-left">
                                <span class="container_content-text"><?php echo e($item->brief); ?></span>
                                <span class="container_content-time"><?php echo e($item->source); ?> <?php echo e($item->published_at->format("Y-m-d")); ?></span>
                            </li>
                        <?php endif; ?>
                        </ul>
                    </div>
<?php else: ?>
                <li class="container_img pull-left">
                    <a href="<?php echo e(route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id])); ?>" target="_blank">
                        <img src="<?php echo e(img_resize($item->banner_url,400,276)); ?>" alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
                    </a>
                </li>
                <li class="container_content pull-left">
                    <span class="container_content-text"><?php echo e($item->brief); ?></span>
                    <span class="container_content-time"><?php echo e($item->source); ?> <?php echo e($item->published_at->format("Y-m-d")); ?></span>
                </li>
                <?php endif; ?>
                    </ul>
                </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

            加载更多 //已全部加载完毕
<?php if($loading): ?>
        <p class="container_loading-more">加载更多</p>
        <?php else: ?>
        <p class="container_loading-more">已加载全部内容</p>
        <?php endif; ?>

            </div>-->
        <!-- E 内容主体部分 -->

        <?php $__env->stopSection(); ?>

        <?php $__env->startSection('script'); ?>
            <script type="text/javascript">
                POSITION_ID = "<?php echo e($position->id); ?>"
            </script>
            <script src="<?php echo e(asset('front/js/list.js?201810252124')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>