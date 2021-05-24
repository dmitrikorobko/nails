{{--
  Template Name: All judges
--}}
@php

// WP_User_Query arguments
$args = array (
    'role'           => 'judge',
    'order'          => 'ASC',
    'orderby'        => 'user_registered'
);

    // The User Query
$user_query = new WP_User_Query( $args );

@endphp

@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')
    @include('partials.content-page')

        @if (!empty($user_query->results))
            @foreach ($user_query->results as $user)
            @php
                $image = get_field('field_60813af2e4e0e', 'user_'.$user->ID.'');
                $regalia = get_field('field_6081a017220dd', 'user_'.$user->ID.'');
            @endphp
                <section class="judges">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            @if ($image)
                            <img class="avatar" src="{{esc_url($image['sizes']['medium_large'])}}">
                            @endif
                        </div>
                        <div class="col-12 col-md-8">
                            <h3>{{$user->display_name}}</h3>
                            @if ($regalia)
                            {{the_field('field_6081a017220dd', 'user_'.$user->ID.'')}}
                            @endif
                        </div>
                    </div>
                </section>
            @endforeach
        @endif 
        @php wp_reset_query(); @endphp

  @endwhile
@endsection
