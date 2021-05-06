{{--
  Template Name: All nominations
--}}
@php
$online_nominations = [];
$nominations = new WP_Query( array(
        'post_type' => 'nomination',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

@endphp

@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')

    <div class="row nomination">
        <div class="col-12 text-center"><h2>{{ __('Intramural/Online competition','sage') }}</h2></div>
            
    </div>
    
        @if ( $nominations->have_posts() )
            @while ($nominations->have_posts()) @php $nominations->the_post(); global $post; $id = $post->ID; @endphp
     
            
                @if ( get_field('type') === 'offline')
                <div class="row nomination">
                    <div class="col-12">
                    <a href="{{the_permalink()}}">
                    <ul>
                        <li>№{{ get_field('number')}}</li>
                        <li>{{ get_field('duration')}}</li>
                        <li>{{ the_title()}}</li>
                    </ul>
                    </a>
                    </div>
                </div>
                @elseif(get_field('type') ==='online')
                    @php
                    $online_nominations[get_field('subtype')][get_field('number')] = array($id => get_the_title());
                    @endphp
                @endif
            
  
            @endwhile
            @php wp_reset_postdata(); @endphp
            @else

        @endif @php wp_reset_query(); @endphp
        <div class="row nomination online">
        <div class="col-12 text-center"><h2>{{ __('Online competition','sage') }}</h2></div>
            
        </div>
            @if (!empty($online_nominations))
            @foreach($online_nominations as $type => $subtype)
            <h3 class="h3-nomination">{{ $type }}</h3>
                @foreach($subtype as $number => $nomination )
                <div class="row nomination online">
                    <div class="col-12">
                    <a href="{{the_permalink(key($nomination))}}">
                    <ul>
                        <li>№{{$number}} </li>
                        <li>{{ html_entity_decode($nomination[key($nomination)]) }}</li>
                    </ul>
                    </a>
                    </div>
                </div>
                @endforeach

            @endforeach
            @else
                <p>{{ __('No online nominations','sage') }}</p>
            @endif
    
    <div class="row mt-4">
        <div class="col-12">
        @include('partials.content-page')
        </div>
    </div>
    

  @endwhile
@endsection
