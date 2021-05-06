<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    
    <?php echo $__env->make('partials.page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <section class="rules">
        <div class="row">
            <div class="col-12">
                <?php echo e(the_field('general_top_text')); ?>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 mb-3 mt-1">
                <hr>
            </div>
            <div class="col-12 col-md-6">
                <?php echo e(the_field('general_left_text')); ?>

            </div>
            <div class="col-12 col-md-6">
                <?php echo e(the_field('general_right_text')); ?>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <?php echo e(the_field('general_bottom_text')); ?>

            </div>
            <div class="col-12">
            <hr>
        </div>
        </div>
    </section>
    <section class="judge-rules">
        <div class="row">
            <div class="col-12">
                <h2><?php echo e(the_field('judge_heading')); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo e(the_field('judge_main_text')); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <?php echo e(the_field('judge_left_text')); ?>

            </div>
            <div class="col-12 col-md-6">
                <?php echo e(the_field('judge_right_text')); ?>

            </div>
        </div>
    </section>

  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>