<?php if(is_user_logged_in()): ?>
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    
    <?php echo $__env->make('partials.page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.content-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <section>
        <div class="row">
            <div class="col-12 role-chooser">
                <ul>

					<?php while( have_rows('field_60926a109777a') ): the_row(); ?>
						<? $role_page = get_sub_field('field_60926a529777c'); 
                            $role_name = get_sub_field('field_60926a4b9777b');
                        ?>
                        <a href="<?php echo e(get_permalink($role_page)); ?>">
								<li>
                                    
                                        <?php echo e($role_name); ?>

                                   
                                </li> </a>

					<?php endwhile; ?>

			    </ul>
            </div>
        </div>
    </section>
  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>