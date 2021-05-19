{{--
  Template Name: Sponsor packages
--}}
@php

$packages = new WP_Query( array(
        'post_type' => 'sponsor_package',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

@endphp

@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')
    @include('partials.content-page')

        @if ( $packages->have_posts() )
        <div class="row sponsor-package">
          <div class="col-12"><h4>{{ __('All Sponsor packages','sage') }}</h4> </div>
        </div>
            @while ($packages->have_posts()) @php $packages->the_post(); global $post; $id = $post->ID;
            $the_content = apply_filters('the_content', get_the_content());
             @endphp

                <div class="row accordeon sponsor-package">
                  <div class="col-12">
                    <a class="open-collapse collapsed" data-toggle="collapse" href="#package-{{the_field('nr')}}" role="button" aria-expanded="false" aria-controls="package-{{the_field('nr')}}">
                      <h3>№{{ the_field('nr')}} {{the_title()}}</h3>
                      <div class="icons">
                        <img class="icon-plus" src="<?= ASSETS; ?>/images/plus.svg">
                        <img class="icon-minus" src="<?= ASSETS; ?>/images/minus.svg">
                      </div>
                    </a>
                  </div>
                
                  <div class="col-12 collapse content" id="package-{{the_field('nr')}}">
                      <div class="content-wrap">
                        <div class="content">
                          {{the_field('decription')}}
                          <b>{{ __('Package price: ','sage') }} {{the_field('price')}} €</b>
                        </div>
                      </div>
                  </div>
                </div>
            @endwhile
            @php wp_reset_postdata(); @endphp
            @else

        @endif @php wp_reset_query(); @endphp


    

  @endwhile
@endsection
