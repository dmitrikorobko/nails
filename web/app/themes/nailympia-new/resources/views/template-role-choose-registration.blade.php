{{--
  Template Name: Role Chooser
--}}
@extends('layouts.app')
@if (is_user_logged_in())
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
@endif
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')
    @include('partials.content-page')
    <section>
        <div class="row">
            <div class="col-12 role-chooser">
                <ul>

					<?php while( have_rows('field_60926a109777a') ): the_row(); ?>
						<? $role_page = get_sub_field('field_60926a529777c'); 
                            $role_name = get_sub_field('field_60926a4b9777b');
                        ?>
                        <a href="{{get_permalink($role_page)}}">
								<li>
                                    
                                        {{$role_name}}
                                   
                                </li> </a>

					<?php endwhile; ?>

			    </ul>
            </div>
        </div>
    </section>
  @endwhile
@endsection
