{{--
  Template Name: Sponsor Registration
--}}

@extends('layouts.app')

@if (is_user_logged_in())
    <?php 
        Redirect(esc_url(um_get_core_page( 'account' )), false);
    ?>
@endif

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <form class="registration-form" id="sponsor" enctype = 'multipart/form-data' data-language={{ICL_LANGUAGE_CODE}}>
        <div class="step-item active" data-step="step-1">
            @include('partials.form-userdata', ['form' => 'sponsor'])
            <div class="form-footer">
                <div class="row align-items-center">
                    <div class="col-6 col-md-6 text-left">

                    </div>
                    <div class="col-6 col-md-6 text-right">                       
                        <span class="stepNr">{{ __('Step','sage') }} 1/1 </span>
                        <button class="btn small green submit-btn" type="submit" data-current-step="step-1">{{ __('Finish','sage') }} </button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="user-type" value="sponsor">
        <input type="hidden" name="action" value="register_user">

    </form>
  
    @include('partials.form-modal', ['form' => 'sponsor'])
  @endwhile
@endsection
