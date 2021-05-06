<?php
$online_nominations = [];
$nominations = new WP_Query( array(
        'post_type' => 'nomination',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

?>


<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php the_post() ?>
    
    <?php echo $__env->make('partials.page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row nomination">
        <div class="col-12 text-center"><h2><?php echo e(__('Intramural/Online competition','sage')); ?></h2></div>
            
    </div>
    
        <?php if( $nominations->have_posts() ): ?>
            <?php while($nominations->have_posts()): ?> <?php $nominations->the_post(); global $post; $id = $post->ID; ?>
     
            
                <?php if( get_field('type') === 'offline'): ?>
                <div class="row nomination">
                    <div class="col-12">
                    <a href="<?php echo e(the_permalink()); ?>">
                    <ul>
                        <li>№<?php echo e(get_field('number')); ?></li>
                        <li><?php echo e(get_field('duration')); ?></li>
                        <li><?php echo e(the_title()); ?></li>
                    </ul>
                    </a>
                    </div>
                </div>
                <?php elseif(get_field('type') ==='online'): ?>
                    <?php
                    $online_nominations[get_field('subtype')][get_field('number')] = array($id => get_the_title());
                    ?>
                <?php endif; ?>
            
  
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else: ?>

        <?php endif; ?> <?php wp_reset_query(); ?>
        <div class="row nomination online">
        <div class="col-12 text-center"><h2><?php echo e(__('Online competition','sage')); ?></h2></div>
            
        </div>
            <?php if(!empty($online_nominations)): ?>
            <?php $__currentLoopData = $online_nominations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $subtype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h3 class="h3-nomination"><?php echo e($type); ?></h3>
                <?php $__currentLoopData = $subtype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number => $nomination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row nomination online">
                    <div class="col-12">
                    <a href="<?php echo e(the_permalink(key($nomination))); ?>">
                    <ul>
                        <li>№<?php echo e($number); ?> </li>
                        <li><?php echo e(html_entity_decode($nomination[key($nomination)])); ?></li>
                    </ul>
                    </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p><?php echo e(__('No online nominations','sage')); ?></p>
            <?php endif; ?>
    
    <div class="row mt-4">
        <div class="col-12">
        <?php echo $__env->make('partials.content-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
    

  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>