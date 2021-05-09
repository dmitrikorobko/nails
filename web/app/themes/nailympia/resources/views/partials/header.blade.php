<div class="topbar">
  <div class="container">
    <div class="row">
      <div class="col-6">
      @hasoptions('social_list')
        <ul class="social">
        @options('social_list')
          <li>
            <a href="@sub('url')" target="_blank"><img src="@sub('icon', 'url')"></a>
          </li>
        @endoptions
        </ul>
      @endhasoptions
      </div>
      <div class="col-6 d-flex justify-content-end">
        {{do_action('wpml_add_language_selector')}}
      </div>
    </div>
  </div>
</div>
<header class="site-header">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
    <a class="logo" href="{{ home_url('/') }}"><img src="@option('logo', 'url')"></a>
    
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#headerMenu" aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
      <img src="<?= ASSETS; ?>images/menu_open.svg" class="menu_open">
      <img src="<?= ASSETS; ?>images/menu_close.svg" class="menu_close">
    </button>
    <div class="collapse navbar-collapse" id="headerMenu">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-nav mr-auto']) !!}
      @endif
    </div>
    @if (!is_user_logged_in())
    <a class="login btn btn-primary btn-lg" href="<?php echo esc_url(um_get_core_page( 'login' ));  ?>">{{ __('Personal area','sage') }}</a>
    @else
    <a class="login btn btn-primary btn-lg" href="<?php echo esc_url(um_get_core_page( 'logout' )); ?>">
			<?php _e( 'Logout', 'ultimate-member' ); ?>
		</a>
    @endif
    </nav>

  </div>
</header>
@if (is_front_page())
<section class="header-banner">
  <div class="container">
    <div class="row">
    <div class="col-12">
       <img src="@option('banner', 'url')"></a>
    </div>
    </div>
  </div>
</section>
@endif