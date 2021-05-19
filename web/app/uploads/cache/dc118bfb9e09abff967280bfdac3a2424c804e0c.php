<?php

$packages = new WP_Query( array(
        'post_type' => 'sponsor_package',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

?>


<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    
    <?php echo $__env->make('partials.page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.content-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php if( $packages->have_posts() ): ?>
        <div class="row sponsor-package">
          <div class="col-12"><h4><?php echo e(__('All Sponsor packages','sage')); ?></h4> </div>
        </div>
            <?php while($packages->have_posts()): ?> <?php $packages->the_post(); global $post; $id = $post->ID;
            $the_content = apply_filters('the_content', get_the_content());
             ?>

                <div class="row accordeon sponsor-package">
                  <div class="col-12">
                    <a class="open-collapse collapsed" data-toggle="collapse" href="#package-<?php echo e(the_field('nr')); ?>" role="button" aria-expanded="false" aria-controls="package-<?php echo e(the_field('nr')); ?>">
                      <h3>№<?php echo e(the_field('nr')); ?> <?php echo e(the_title()); ?></h3>
                      <div class="icons">
                        <img class="icon-plus" src="<?= ASSETS; ?>/images/plus.svg">
                        <img class="icon-minus" src="<?= ASSETS; ?>/images/minus.svg">
                      </div>
                    </a>
                  </div>
                
                  <div class="col-12 collapse content" id="package-<?php echo e(the_field('nr')); ?>">
                      <div class="content-wrap">
                        <div class="content">
                          <?php echo e(the_field('decription')); ?>

                          <b><?php echo e(__('Package price: ','sage')); ?> <?php echo e(the_field('price')); ?> €</b>
                        </div>
                      </div>
                  </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else: ?>

        <?php endif; ?> <?php wp_reset_query(); ?>


    

  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>