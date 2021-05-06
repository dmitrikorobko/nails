<footer>
  <div class="container">
    <div class="row pt-2">
      <div class="col-12 col-lg-6">
        <div id="map"></div>
      </div>
      <div class="col-12 col-lg-6">
      @option('footer_text')
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
    </div>
    <div class="row footerbar">
      <div class="col-12 col-lg-5 order-2 order-lg-1 copyright">
      {{ date('Y') }} {{ get_bloginfo( 'name' ) }}
      </div>
      <div class="col-12 col-lg-7 order-1 order-lg-2">
      @if (has_nav_menu('footer_menu'))
        {!! wp_nav_menu(['theme_location' => 'footer_menu']) !!}
      @endif
      </div>
    </div>
  </div>
</footer>
