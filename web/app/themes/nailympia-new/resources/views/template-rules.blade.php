{{--
  Template Name: Rules
--}}
@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')
    <section class="rules">
        <div class="row">
            <div class="col-12">
                {{the_field('general_top_text')}}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 mb-3 mt-1">
                <hr>
            </div>
            <div class="col-12 col-md-6">
                {{the_field('general_left_text')}}
            </div>
            <div class="col-12 col-md-6">
                {{the_field('general_right_text')}}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                {{the_field('general_bottom_text')}}
            </div>
            <div class="col-12">
            <hr>
        </div>
        </div>
    </section>
    <section class="judge-rules">
        <div class="row">
            <div class="col-12">
                <h2>{{the_field('judge_heading')}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{the_field('judge_main_text')}}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                {{the_field('judge_left_text')}}
            </div>
            <div class="col-12 col-md-6">
                {{the_field('judge_right_text')}}
            </div>
        </div>
    </section>

  @endwhile
@endsection
