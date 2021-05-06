<footer>
  <div class="container">
    <div class="row pt-2">
      <div class="col-12 col-lg-6">
        <div id="map"></div>
      </div>
      <div class="col-12 col-lg-6">
      <?= get_field('footer_text', 'option'); ?>
      <?php if (have_rows('social_list', 'option')) : ?>
        <ul class="social">
        <?php if (have_rows('social_list', 'option')) : ?><?php while (have_rows('social_list', 'option')) : the_row(); ?>
          <li>
            <a href="<?= get_sub_field('url'); ?>" target="_blank"><img src="<?= get_sub_field('icon')['url']; ?>"></a>
          </li>
        <?php endwhile; endif; ?>
        </ul>
      <?php endif; ?>
      </div>
    </div>
    <div class="row footerbar">
      <div class="col-12 col-lg-5 order-2 order-lg-1 copyright">
      <?php echo e(date('Y')); ?> <?php echo e(get_bloginfo( 'name' )); ?>

      </div>
      <div class="col-12 col-lg-7 order-1 order-lg-2">
      <?php if(has_nav_menu('footer_menu')): ?>
        <?php echo wp_nav_menu(['theme_location' => 'footer_menu']); ?>

      <?php endif; ?>
      </div>
    </div>
  </div>
</footer>
