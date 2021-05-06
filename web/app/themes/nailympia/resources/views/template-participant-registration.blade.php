{{--
  Template Name: Participant Registration
--}}

@extends('layouts.app')

@if (is_user_logged_in())
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
@endif
@php

$offline_nominations = [];
$online_nominations = [];


$categories = new WP_Query( array(
        'post_type' => 'division',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );

$nominations = new WP_Query( array(
        'post_type' => 'nomination',
        'posts_per_page' => -1,
        'order' => 'ASC',
) );



@endphp
@if ( $nominations->have_posts() )
    @while ($nominations->have_posts()) @php $nominations->the_post(); global $post; $id = $post->ID; @endphp
        @php
       
        if ( get_field('type') === 'offline'){
            $offline_nominations[get_field('number')] = array($id => get_the_title());
        } else if (get_field('type') ==='online') {  
            $online_nominations[get_field('subtype')][get_field('number')] = array($id => get_the_title());
        }
        
        @endphp
    @endwhile
    @php wp_reset_postdata(); @endphp
    @else

@endif @php wp_reset_query(); @endphp

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <form class="registration-form" id="participant" enctype = 'multipart/form-data' data-language={{ICL_LANGUAGE_CODE}}>
        <div class="step-item active" data-step="step-1">
            <div class="category">
                <div class="row">
                    <div class="col-12 heading">
                        <h2>{{ __('Categories','sage') }}</h2>
                        <p>{{ __('Choose the category that suits you','sage') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 cat-list">
                        @if ( $categories->have_posts() )
                            @php
                            $count = 0;
                            @endphp
                            <fieldset class="form-group" id="devision">
                            @while ($categories->have_posts()) @php $categories->the_post(); global $post; $id = $post->ID; @endphp
                            
                                <ul>
                                    <li>
                                        {{ esc_html( get_the_title() ) }}
                                    </li>
                                    <li>
                                        {{ get_field('level') }}
                                    </li>
                                    <li>
                                        {{ get_field('comment') }}
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="catRadios" id="cat-{{ get_field('nr') }}" value="{{$id}}" @php if($count == 0) echo 'required'; @endphp>
                                            <label class="form-check-label btn" for="cat-{{ get_field('nr') }}">
                                                {{ __('Choose','sage') }}
                                            </label>
                                            <div class="invalid-feedback">
                                                {{ __('Please fill this field','sage') }}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                @php 
                                    $online_prices=get_field('online_nomination_prices');
                                    $live_prices=get_field('offline_nomination_prices');
                                @endphp

                                <data class="price-{{ get_field('nr') }}" value='
                                {
                                    "one": "{{$live_prices['one']}}",
                                    "two": "{{$live_prices['two']}}",
                                    "three": "{{$live_prices['thre_and_more']}}",
                                    "four": "{{$live_prices['four_and_more']}}",
                                    "boxed": "{{$online_prices['boxed']}}",
                                    "photo": "{{$online_prices['photo']}}",
                                    "3d": "{{$online_prices['3d']}}",
                                    "video": "{{$online_prices['video']}}"
                                }
                                '></data>
                                @php
                                $count++;
                                @endphp

                            @endwhile
                            
                            </fieldset>
                            @php wp_reset_postdata(); @endphp
                        @else
                            <p>{{ __('No categories','sage') }}</p>
                        @endif @php wp_reset_query(); @endphp
                        <p class="text-right">
                            <a href="{{get_permalink(icl_object_id(476, 'page'))}}" class="more" target="_blank">{{get_the_title(icl_object_id(476, 'page'))}}</a>                        </p>
                    </div>
                </div>
            </div>
            <div class="nomination">
                <div class="row">
                    <div class="col-12 heading">
                        <h2>{{ __('Nominations','sage') }}</h2>
                        <p>{{ __('Select the nominations in which you want to participate','sage') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 nominations-offline">
                        <div class="subheadig">
                            <h3>{{ __('Intramural/Online competition','sage') }}</h3>
                            <p>{{ __('Competitions are held in pavilions or online','sage') }}</p>
                        </div>
                        <fieldset class="form-group" id="offlineNominations">    
                            @if (!empty($offline_nominations))
                                @foreach($offline_nominations as $number => $nomination)

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{key($nomination)}}" name="offline-{{ $number }}" id="offline-{{ $number }}">
                                        <label class="form-check-label" for="offline-{{ $number }}">
                                        №{{$number}} {{ html_entity_decode($nomination[key($nomination)]) }}
                                        </label>
                                    </div>

                                @endforeach
                            @else
                                <p>{{ __('No offline nominations','sage') }}</p>
                            @endif

                        </fieldset>
                    </div>
                    <div class="col-12 col-lg-6 nominations-online">
                        <div class="subheadig">
                            <h3>{{ __('Online competition','sage') }}</h3>
                            <p>{{ __('Competitions are held online','sage') }}</p>
                        </div>
                        <fieldset class="form-group" id="onlineNominations">
                            
                            @if (!empty($online_nominations))
                                @foreach($online_nominations as $type => $subtype)
                                    <h4>{{ $type }}</h4>
                                    @foreach($subtype as $number => $nomination )

                                    <div class="form-check">
                                        <input class="form-check-input {{ $type }}" type="checkbox" value="{{key($nomination)}}" name="online-{{ $number }}" id="online-{{ $number }}">
                                        <label class="form-check-label" for="online-{{ $number }}">
                                        №{{$number}} {{ html_entity_decode($nomination[key($nomination)]) }}
                                        </label>
                                    </div>
                                    @endforeach

                                @endforeach
                            @else
                                <p>{{ __('No online nominations','sage') }}</p>
                            @endif

                        </fieldset>
                    </div>
                    <div class="col-12 error-message-cat-1-2">
                        <p>{{ __('Please choose at least one nomination!','sage') }}</p>
                    </div>  
                    <div class="col-12 error-message-cat-3">
                        <p>{{ __('Please choose at least three live nominations!','sage') }}</p>
                    </div>
                    <div class="col-12">
                        <p class="text-right">
                                <a href="{{get_permalink(icl_object_id(472, 'page'))}}" class="more" target="_blank">{{get_the_title(icl_object_id(472, 'page'))}}</a>
                                <a href="{{get_permalink(icl_object_id(478, 'page'))}}" class="more" style="margin-left: 1rem;" target="_blank">{{get_the_title(icl_object_id(478, 'page'))}}</a>
                        </p>
                    </div>
                   
                </div>
            </div>
            <div class="form-footer">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 costs">
                    {{ __('Registration cost will be:','sage') }} <span id="regPrice">0</span>€
                    </div>
                    <div class="col-12 col-md-6 stepswitch">
                        
                            <span class="stepNr">{{ __('Step','sage') }} 1/2 </span>
                            <button class="btn small green step-btn" data-step="step-2" data-current-step="step-1">{{ __('Next','sage') }} </button>


                    </div>
                </div>
            </div>
        </div>
        <div class="step-item" data-step="step-2">
            @include('partials.form-userdata', ['form' => 'participant'])
            <div class="form-footer">
                <div class="row align-items-center">
                    <div class="col-6 col-md-6 text-left">
                        <button class="btn small blue step-btn" data-step="step-1" data-current-step="last">{{ __('Back','sage') }} </button>
                    </div>
                    <div class="col-6 col-md-6 text-right">                       
                        <span class="stepNr">{{ __('Step','sage') }} 2/2 </span>
                        <button class="btn small green submit-btn" type="submit" data-current-step="step-2">{{ __('Finish','sage') }} </button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="user-type" value="participant">
        <input type="hidden" name="total-price" value="" id="total-price">
        <input type="hidden" name="action" value="register_user">

    </form>
  
    @include('partials.form-modal', ['form' => 'participant'])
  @endwhile
@endsection
