<?php if(is_user_logged_in()): ?>
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
<?php endif; ?>
<?php

$offline_nominations = [];
$online_nominations = [];


$categories = new WP_Query( array(
        'post_type' => 'division',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

$nominations = new WP_Query( array(
        'post_type' => 'nomination',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );



?>
<?php if( $nominations->have_posts() ): ?>
    <?php while($nominations->have_posts()): ?> <?php $nominations->the_post(); global $post; $id = $post->ID; ?>
        <?php
       
        if ( get_field('type') === 'offline'){
            $offline_nominations[get_field('number')] = array($id => get_the_title());
        } else if (get_field('type') ==='online') {  
            $online_nominations[get_field('subtype')][get_field('number')] = array($id => get_the_title());
        }
        
        ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php else: ?>

<?php endif; ?> <?php wp_reset_query(); ?>

<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    <form class="registration-form" id="participant" enctype = 'multipart/form-data' data-language=<?php echo e(ICL_LANGUAGE_CODE); ?>>
        <div class="step-item active" data-step="step-1">
            <div class="category">
                <div class="row">
                    <div class="col-12 heading">
                        <h2><?php echo e(__('Categories','sage')); ?></h2>
                        <p><?php echo e(__('Choose the category that suits you','sage')); ?></p>
                        <div class="error-message-cat-1-2">
                        <p><?php echo e(__('Please choose at least one nomination!','sage')); ?></p>
                    </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 cat-list">
                        <?php if( $categories->have_posts() ): ?>
                            <?php
                            $count = 0;
                            ?>
                            <fieldset class="form-group" id="devision">
                            <?php while($categories->have_posts()): ?> <?php $categories->the_post(); global $post; $id = $post->ID; ?>
                            
                                <ul>
                                    <li>
                                        <?php echo e(esc_html( get_the_title() )); ?>

                                    </li>
                                    <li>
                                        <?php echo e(get_field('level')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(get_field('comment')); ?>

                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="catRadios" id="cat-<?php echo e(get_field('nr')); ?>" value="<?php echo e($id); ?>" <?php if($count == 0) echo 'required'; ?>>
                                            <label class="form-check-label btn" for="cat-<?php echo e(get_field('nr')); ?>">
                                                <?php echo e(__('Choose','sage')); ?>

                                            </label>
                                            <div class="invalid-feedback">
                                                <?php echo e(__('Please fill this field','sage')); ?>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php 
                                    $online_prices=get_field('online_nomination_prices');
                                    $live_prices=get_field('offline_nomination_prices');
                                ?>

                                <data class="price-<?php echo e(get_field('nr')); ?>" value='
                                {
                                    "one": "<?php echo e($live_prices['one']); ?>",
                                    "two": "<?php echo e($live_prices['two']); ?>",
                                    "three": "<?php echo e($live_prices['thre_and_more']); ?>",
                                    "four": "<?php echo e($live_prices['four_and_more']); ?>",
                                    "boxed": "<?php echo e($online_prices['boxed']); ?>",
                                    "photo": "<?php echo e($online_prices['photo']); ?>",
                                    "3d": "<?php echo e($online_prices['3d']); ?>",
                                    "video": "<?php echo e($online_prices['video']); ?>"
                                }
                                '></data>
                                <?php
                                $count++;
                                ?>

                            <?php endwhile; ?>
                            
                            </fieldset>
                            <?php wp_reset_postdata(); ?>
                        <?php else: ?>
                            <p><?php echo e(__('No categories','sage')); ?></p>
                        <?php endif; ?> <?php wp_reset_query(); ?>
                        <p class="text-right">
                            <a href="<?php echo e(get_permalink(icl_object_id(476, 'page'))); ?>" class="more" target="_blank"><?php echo e(get_the_title(icl_object_id(476, 'page'))); ?></a>                        </p>
                    </div>
                </div>
            </div>
            <div class="nomination">
                <div class="row">
                    <div class="col-12 heading">
                        <h2><?php echo e(__('Nominations','sage')); ?></h2>
                        <p><?php echo e(__('Select the nominations in which you want to participate','sage')); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 nominations-offline">
                        <div class="subheadig">
                            <h3><?php echo e(__('Intramural/Online competition','sage')); ?></h3>
                            <p><?php echo e(__('Competitions are held in pavilions or online','sage')); ?></p>
                        </div>
                        <fieldset class="form-group" id="offlineNominations">    
                            <?php if(!empty($offline_nominations)): ?>
                                <?php $__currentLoopData = $offline_nominations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number => $nomination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?php echo e(key($nomination)); ?>" name="offline-<?php echo e($number); ?>" id="offline-<?php echo e($number); ?>">
                                        <label class="form-check-label" for="offline-<?php echo e($number); ?>">
                                        №<?php echo e($number); ?> <?php echo e(html_entity_decode($nomination[key($nomination)])); ?>

                                        </label>
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p><?php echo e(__('No offline nominations','sage')); ?></p>
                            <?php endif; ?>

                        </fieldset>
                    </div>
                    <div class="col-12 col-lg-6 nominations-online">
                        <div class="subheadig">
                            <h3><?php echo e(__('Online competition','sage')); ?></h3>
                            <p><?php echo e(__('Competitions are held online','sage')); ?></p>
                        </div>
                        <fieldset class="form-group" id="onlineNominations">
                            
                            <?php if(!empty($online_nominations)): ?>
                                <?php $__currentLoopData = $online_nominations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $subtype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <h4><?php echo e($type); ?></h4>
                                    <?php $__currentLoopData = $subtype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number => $nomination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="form-check">
                                        <input class="form-check-input <?php echo e($type); ?>" type="checkbox" value="<?php echo e(key($nomination)); ?>" name="online-<?php echo e($number); ?>" id="online-<?php echo e($number); ?>">
                                        <label class="form-check-label" for="online-<?php echo e($number); ?>">
                                        №<?php echo e($number); ?> <?php echo e(html_entity_decode($nomination[key($nomination)])); ?>

                                        </label>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p><?php echo e(__('No online nominations','sage')); ?></p>
                            <?php endif; ?>

                        </fieldset>
                    </div>
                    <div class="col-12 error-message-cat-3">
                        <p><?php echo e(__('Please choose at least three live nominations!','sage')); ?></p>
                    </div>
                    <div class="col-12">
                        <p class="text-right">
                                <a href="<?php echo e(get_permalink(icl_object_id(472, 'page'))); ?>" class="more" target="_blank"><?php echo e(get_the_title(icl_object_id(472, 'page'))); ?></a>
                                <a href="<?php echo e(get_permalink(icl_object_id(478, 'page'))); ?>" class="more" style="margin-left: 1rem;" target="_blank"><?php echo e(get_the_title(icl_object_id(478, 'page'))); ?></a>
                        </p>
                    </div>
                   
                </div>
            </div>
            <div class="form-footer">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 costs">
                    <?php echo e(__('Registration cost will be:','sage')); ?> <span id="regPrice">0</span>€
                    </div>
                    <div class="col-12 col-md-6 stepswitch">
                        
                            <span class="stepNr"><?php echo e(__('Step','sage')); ?> 1/2 </span>
                            <button class="btn small green step-btn" data-step="step-2" data-current-step="step-1"><?php echo e(__('Next','sage')); ?> </button>


                    </div>
                </div>
            </div>
        </div>
        <div class="step-item" data-step="step-2">
            <?php echo $__env->make('partials.form-userdata', ['form' => 'participant'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="form-footer">
                <div class="row align-items-center">
                    <div class="col-6 col-md-6 text-left">
                        <button class="btn small blue step-btn" data-step="step-1" data-current-step="last"><?php echo e(__('Back','sage')); ?> </button>
                    </div>
                    <div class="col-6 col-md-6 text-right">                       
                        <span class="stepNr"><?php echo e(__('Step','sage')); ?> 2/2 </span>
                        <button class="btn small green submit-btn" type="submit" data-current-step="step-2"><?php echo e(__('Finish','sage')); ?> </button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="user-type" value="participant">
        <input type="hidden" name="total-price" value="" id="total-price">
        <input type="hidden" name="action" value="register_user">

    </form>
  
    <?php echo $__env->make('partials.form-modal', ['form' => 'participant'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>