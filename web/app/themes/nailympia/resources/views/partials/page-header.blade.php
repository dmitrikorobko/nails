<div class="page-header">
  <?php
   global $wp;
   if(is_page(icl_object_id(271, 'page'))){
    echo '<h1>'. esc_html( um_user( 'display_name' ) ).'</h1>';
   } else {
     echo '<h1>'. App::title() .'</h1>';
   }
  ?>
</div>
