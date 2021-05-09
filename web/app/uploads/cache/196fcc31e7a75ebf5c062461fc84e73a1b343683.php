<?php if(is_user_logged_in()): ?>
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    <form class="registration-form" id="judge" enctype = 'multipart/form-data' data-language=<?php echo e(ICL_LANGUAGE_CODE); ?>>
        <div class="step-item active" data-step="step-1">
            <?php echo $__env->make('partials.form-userdata', ['form' => 'judge'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="form-footer">
                <div class="row align-items-center">
                    <div class="col-6 col-md-6 text-left">

                    </div>
                    <div class="col-6 col-md-6 text-right">                       
                        <span class="stepNr"><?php echo e(__('Step','sage')); ?> 1/1 </span>
                        <button class="btn small green submit-btn" type="submit" data-current-step="step-1"><?php echo e(__('Finish','sage')); ?> </button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="user-type" value="judge">
        <input type="hidden" name="action" value="register_user">

    </form>
  
    <?php echo $__env->make('partials.form-modal', ['form' => 'judge'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>