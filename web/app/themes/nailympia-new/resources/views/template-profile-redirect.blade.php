{{--
  Template Name: Profile Redirect
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
    
  @endwhile
@endsection
