<?php

// WP_User_Query arguments
$args = array (
    'role'           => 'judge',
    'order'          => 'ASC',
    'orderby'        => 'user_registered'
);

    // The User Query
$user_query = new WP_User_Query( $args );

?>


<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    
    <?php echo $__env->make('partials.page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.content-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php if(!empty($user_query->results)): ?>
            <?php $__currentLoopData = $user_query->results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $image = get_field('field_60813af2e4e0e', 'user_'.$user->ID.'');
                $regalia = get_field('field_6081a017220dd', 'user_'.$user->ID.'');
            ?>
                <section class="judges">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <?php if($image): ?>
                            <img class="avatar" src="<?php echo e(esc_url($image['sizes']['medium_large'])); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="col-12 col-md-8">
                            <h3><?php echo e($user->display_name); ?></h3>
                            <?php if($regalia): ?>
                            <?php echo e(the_field('field_6081a017220dd', 'user_'.$user->ID.'')); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?> 
        <?php wp_reset_query(); ?>

  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>