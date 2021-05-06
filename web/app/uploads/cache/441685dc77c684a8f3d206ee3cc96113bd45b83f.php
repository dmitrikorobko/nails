<?php

$categories = new WP_Query( array(
        'post_type' => 'division',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

?>


<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    
    <?php echo $__env->make('partials.page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php if( $categories->have_posts() ): ?>
            <?php while($categories->have_posts()): ?> <?php $categories->the_post(); global $post; $id = $post->ID; ?>

                <div class="row devision  <?php if(get_field('nr') == '1'): ?> mt-5 <?php endif; ?>">
                    <div class="col-12 col-md-12 col-lg-3 text-center text-lg-left">
                        <h2><?php echo e(the_title()); ?></h2>
                    </div>
                    <div class="col-12 col-md-12 col-lg-9">
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                <?php echo e(__('Description','sage')); ?>

                            </div>
                            <div class="col-12 col-md-9">
                                <?php echo e(the_field('description')); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                <?php echo e(__('Intramural/Online competition','sage')); ?>

                            </div>
                            <div class="col-12 col-md-9">
                                <?php if (have_rows('offline_nomination_prices')) : ?><?php while (have_rows('offline_nomination_prices')) : the_row(); ?>
                                <?php if(get_field('nr') == '3'): ?>
                                    <ul>
                                        <li>
                                            <?php echo e(__('ART Master only (minimum 3 nominations)','sage')); ?> - <?= get_sub_field('thre_and_more'); ?> €
                                        </li>
                                        <li>
                                            <?php echo e(__('Master Tech (at least 3 nominations)','sage')); ?> - <?= get_sub_field('thre_and_more'); ?> €
                                        </li>
                                        <li>
                                            4 <?php echo e(__('nominations and more','sage')); ?> - <?= get_sub_field('four_and_more'); ?> €
                                        </li>
                                    </ul>
                                <?php else: ?>
                                <ul>
                                    <li>
                                        1 <?php echo e(__('nomination','sage')); ?> - <?= get_sub_field('one'); ?> €
                                    </li>
                                    <li>
                                        2 <?php echo e(__('nomination','sage')); ?> - <?= get_sub_field('two'); ?> €
                                    </li>
                                    <li>
                                        3 <?php echo e(__('nominations and more','sage')); ?> - <?= get_sub_field('thre_and_more'); ?> €
                                    </li>
                                </ul>
                                <?php endif; ?>
                                <?php endwhile; endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                <?php echo e(__('Online competition','sage')); ?>

                            </div>
                            <div class="col-12 col-md-9">
                                <?php if (have_rows('online_nomination_prices')) : ?><?php while (have_rows('online_nomination_prices')) : the_row(); ?>
                                <ul>
                                    <li>
                                        boxed - <?= get_sub_field('boxed'); ?> € (1 <?php echo e(__('nomination','sage')); ?>)
                                    </li>
                                    <li>
                                    <?php echo e(__('photo','sage')); ?> - <?= get_sub_field('photo'); ?> € (1 <?php echo e(__('nomination','sage')); ?>)
                                    </li>
                                    <li>
                                        3D - <?= get_sub_field('3d'); ?> € (1 <?php echo e(__('nomination','sage')); ?>)
                                    </li>
                                    <li>
                                    <?php echo e(__('video','sage')); ?> - <?= get_sub_field('video'); ?> € (1 <?php echo e(__('nomination','sage')); ?>)
                                    </li>
                                </ul>
                                <?php endwhile; endif; ?>
                            </div>
                        </div>
                        <?php if(get_field('additional_info')): ?>
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                <?php echo e(__('Additional','sage')); ?>

                            </div>
                            <div class="col-12 col-md-9">
                                <?php echo e(the_field('additional_info')); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else: ?>

        <?php endif; ?> <?php wp_reset_query(); ?>

    <?php echo $__env->make('partials.content-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    

  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>