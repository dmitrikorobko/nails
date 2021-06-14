{{--
  Template Name: All Devisions
--}}
@php

$categories = new WP_Query( array(
        'post_type' => 'division',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

@endphp

@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')

        @if ( $categories->have_posts() )
            @while ($categories->have_posts()) @php $categories->the_post(); global $post; $id = $post->ID; @endphp

                <div class="row devision  @if(get_field('nr') == '1') mt-5 @endif">
                    <div class="col-12 col-md-12 col-lg-3 text-center text-lg-left">
                        <h2>{{the_title()}}</h2>
                    </div>
                    <div class="col-12 col-md-12 col-lg-9">
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                {{ __('Description','sage') }}
                            </div>
                            <div class="col-12 col-md-9">
                                {{the_field('description')}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                {{ __('Intramural/Online competition','sage') }}
                            </div>
                            <div class="col-12 col-md-9">
                                @group('offline_nomination_prices')
                                @if(get_field('nr') == '3')
                                    <ul>
                                        <li>
                                            {{ __('ART Master only (minimum 3 nominations)','sage') }} - @sub('thre_and_more') €
                                        </li>
                                        <li>
                                            {{ __('Master Tech (at least 3 nominations)','sage') }} - @sub('thre_and_more') €
                                        </li>
                                        <li>
                                            4 {{ __('nominations and more','sage') }} - @sub('four_and_more') €
                                        </li>
                                    </ul>
                                @else
                                <ul>
                                    <li>
                                        1 {{ __('nomination','sage') }} - @sub('one') €
                                    </li>
                                    <li>
                                        2 {{ __('nomination','sage') }} - @sub('two') €
                                    </li>
                                    <li>
                                        3 {{ __('nominations and more','sage') }} - @sub('thre_and_more') €
                                    </li>
                                </ul>
                                @endif
                                @endgroup
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                {{ __('Online competition','sage') }}
                            </div>
                            <div class="col-12 col-md-9">
                                @group('online_nomination_prices')
                                <ul>
                                    <li>
                                        boxed - @sub('boxed') € (1 {{ __('nomination','sage') }})
                                    </li>
                                    <li>
                                    {{ __('photo','sage') }} - @sub('photo') € (1 {{ __('nomination','sage') }})
                                    </li>
                                    <li>
                                        3D - @sub('3d') € (1 {{ __('nomination','sage') }})
                                    </li>
                                    <li>
                                    {{ __('video','sage') }} - @sub('video') € (1 {{ __('nomination','sage') }})
                                    </li>
                                </ul>
                                @endgroup
                            </div>
                        </div>
                        @if(get_field('additional_info'))
                        <div class="row">
                            <div class="col-12 col-md-3 title">
                                {{ __('Additional','sage') }}
                            </div>
                            <div class="col-12 col-md-9">
                                {{the_field('additional_info')}}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endwhile
            @php wp_reset_postdata(); @endphp
            @else

        @endif @php wp_reset_query(); @endphp

    @include('partials.content-page')

    

  @endwhile
@endsection
