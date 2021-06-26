<div class="topbar">
  <div class="container">
    <div class="row">
      <div class="col-6">
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
      <div class="col-6 d-flex justify-content-end">
        <?php echo e(do_action('wpml_add_language_selector')); ?>

      </div>
    </div>
  </div>
</div>
<header class="site-header">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
    <a class="logo" href="<?php echo e(home_url('/')); ?>"><img src="<?= get_field('logo', 'option')['url']; ?>"></a>
    
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#headerMenu" aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
      <img src="<?= ASSETS; ?>images/menu_open.svg" class="menu_open">
      <img src="<?= ASSETS; ?>images/menu_close.svg" class="menu_close">
    </button>
    <div class="collapse navbar-collapse" id="headerMenu">
      <?php if(has_nav_menu('primary_navigation')): ?>
        <?php echo wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-nav mr-auto']); ?>

      <?php endif; ?>
    </div>
    <?php if(!is_user_logged_in()): ?>
    <a class="login btn btn-primary btn-lg" href="<?php echo esc_url(um_get_core_page( 'login' ));  ?>"><?php echo e(__('Personal area','sage')); ?></a>
    <?php else: ?>
    <a class="login btn btn-primary btn-lg" href="<?php echo esc_url(um_get_core_page( 'logout' )); ?>">
			<?php _e( 'Logout', 'ultimate-member' ); ?>
		</a>
    <?php endif; ?>
    </nav>

  </div>
</header>
<?php if(is_front_page() || is_page(icl_object_id(644, 'page'))): ?>
<section class="header-banner">
  <div class="container">
    <div class="row">
    <div class="col-12">
       <img src="<?= get_field('banner', 'option')['url']; ?>"></a>
    </div>
    </div>
  </div>
</section>
<?php endif; ?>