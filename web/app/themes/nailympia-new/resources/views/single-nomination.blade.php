{{--
  Template Name: Role Chooser
--}}
@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')
    @include('partials.content-page')
    <div class="row">
      <div class="col-12">
        {{the_field('rules')}}
      </div>
    </div>
  @endwhile
@endsection
