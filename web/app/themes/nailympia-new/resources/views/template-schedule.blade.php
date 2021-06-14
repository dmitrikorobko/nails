{{--
  Template Name: Schedule
--}}

@extends('layouts.app')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    @include('partials.page-header')
    @include('partials.content-page')

    
    <section class="timetable">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#day-1" role="tab" aria-controls="day-1" aria-selected="true">{{the_field('day_1_name')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#day-2" role="tab" aria-controls="day-2" aria-selected="false">{{the_field('day_2_name')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#day-3" role="tab" aria-controls="day-3" aria-selected="false">{{the_field('day_3_name')}}</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="day-1" role="tabpanel" aria-labelledby="day-1-tab">
            @if(have_rows('timetable_1'))
            <ul>
                @while(have_rows('timetable_1')) @php the_row() @endphp
                    <li>{{the_sub_field('time')}} -&nbsp;{{the_sub_field('title')}}</li>
                @endwhile
            </ul>
            @endif
        </div>
        <div class="tab-pane fade" id="day-2" role="tabpanel" aria-labelledby="day-2-tab">
            @if(have_rows('timetable_2'))
            <ul>
                @while(have_rows('timetable_2')) @php the_row() @endphp
                    <li>{{the_sub_field('time')}} -&nbsp;{{the_sub_field('title')}}</li>
                @endwhile
            </ul>
            @endif
        </div>
        <div class="tab-pane fade" id="day-3" role="tabpanel" aria-labelledby="day-3-tab">
            @if(have_rows('timetable_3'))
            <ul>
                @while(have_rows('timetable_3')) @php the_row() @endphp
                    <li>{{the_sub_field('time')}} -&nbsp;{{the_sub_field('title')}}</li>
                @endwhile
            </ul>
            @endif
        </div>
    </div>
    </section>

  @endwhile
@endsection
