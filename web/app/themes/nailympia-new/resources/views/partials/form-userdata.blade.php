<div class="userdata">
        <div class="row">
            <div class="col-12 heading">
                <h2>{{ __('Information','sage') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3>{{ __('Naming','sage') }}</h3>
            </div>
            @if($form==='participant')
                @php
                $teams = new WP_Query( array(
                        'post_type' => 'team',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                ) );
                @endphp	
                <div class="col-12 col-lg-4 form-group">
                    <label for="name" class="required">{{ __('Name and surname of the contestant','sage') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label for="team">{{ __('Team name, if any','sage') }}</label>
                    <input type="text" class="form-control" id="team" name="team">
                </div>

                @if ( $teams->have_posts() )
                    <data class="added-teams" value='{
                            @while ($teams->have_posts()) @php $teams->the_post(); global $post; $id = $post->ID; @endphp
                                "{{ esc_html( get_the_title() ) }}" : "{{$id}}" <?php
                                if (get_next_post_link()) { 
                                    echo ','; 
                                }
                                ?>
                            @endwhile}'></data>
                    @php wp_reset_postdata(); @endphp
                @else
                @endif @php wp_reset_query(); @endphp
            @endif
            @if($form==='judge')
                <div class="col-12 col-lg-4 form-group">
                    <label for="name" class="required">{{ __('Name and surname','sage') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label for="company">{{ __('Company name','sage') }}</label>
                    <input type="text" class="form-control" id="company" name="company">
                </div>
            @endif
            @if($form==='sponsor')
                <div class="col-12 col-lg-4 form-group">
                    <label for="invoiceCompany" class="required">{{ __('Company name','sage') }}</label>
                    <input type="text" class="form-control" id="invoiceCompany" name="invoiceCompany" required>
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label for="reg" class="required">{{ __('Registration number','sage') }}</label>
                    <input type="text" class="form-control" id="reg" name="reg" required>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3>{{ __('Address','sage') }}</h3>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="address" class="required">{{ __('Address','sage') }}</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="country" class="required">{{ __('Country','sage') }}</label>
                <select class="form-control selectpicker" id="country" name="country" data-country="{{ __('Estonia','sage') }}" required></select>
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="city" class="required">{{ __('City','sage') }}</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="postcode" class="required">{{ __('Postcode','sage') }}</label>
                <input type="text" class="form-control" id="postcode" name="postcode"required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3>{{ __('Contacts','sage') }}</h3>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="phone" class="required">{{ __('Phone','sage') }}</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="email" class="required">{{ __('Email','sage') }}</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="password1" class="required">{{ __('Password','sage') }}</label>
                <input type="password" class="form-control" id="password1" name="password1" minlength="6" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="password2" class="required">{{ __('Repeat Password','sage') }}</label>
                <input type="password" class="form-control" id="password2" name="password2" minlength="6" required>
                <div class="invalid-feedback">
                    {{ __('Passwords missmatch or length less than 6 characters','sage') }}
                </div>
            </div>
            @if($form === 'participant' || $form === 'judge')
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="countryRepresent" class="required">{{ __('Country you will represent','sage') }}</label>
                <select class="form-control selectpicker" id="countryRepresent" name="countryRepresent" data-country="{{ __('Estonia','sage') }}"></select>
            </div>
            @endif
        </div>
        @if($form === 'participant' || $form === 'sponsor')
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3>{{ __('Invoice','sage') }}</h3>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="invoiceFor" class="required">{{ __('Invoice for','sage') }}</label>
                <select class="form-control selectpicker" id="invoiceFor" name="invoiceFor">
                    @if($form==='participant')
                    <option value="private">{{ __('Private person','sage') }}</option>
                    @endif
                    <option value="est-legal">{{ __('Estonian legal entity','sage') }}</option>
                    <option value="eu-legal">{{ __('EU legal entity (VAT needed)','sage') }}</option>
                    <option value="world-legal">{{ __('Legal entity outside EU','sage') }}</option>
                </select>
            </div>
            @if($form==='participant')
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional">
                <label for="invoiceCompany" class="required">{{ __('Company name','sage') }}</label>
                <input type="text" class="form-control" id="invoiceCompany" name="invoiceCompany">
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional-reg">
                <label for="reg" class="required">{{ __('Registration number','sage') }}</label>
                <input type="text" class="form-control" id="reg" name="reg">
            </div>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional-vat">
                <label for="vat" class="required">{{ __('VAT number','sage') }}</label>
                <input type="text" class="form-control" id="vat" name="vat">
            </div>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional">
                <label for="invoiceCountry" class="required">{{ __('Country','sage') }}</label>
                <select class="form-control selectpicker" id="invoiceCountry" name="invoiceCountry" data-country="<?php __('Estonia','sage') ?>"></select>
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-8 form-group hide" id="invoice-additional">
                <label for="invoiceAddressInfo" class="required">{{ __('Invoice Full Address and additional info','sage') }}</label>
                <input type="text" class="form-control" id="invoiceAddressInfo" name="invoiceAddressInfo">
            </div>
            @endif
            @if($form==='sponsor')
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional-vat">
                <label for="vat" class="required">{{ __('VAT number','sage') }}</label>
                <input type="text" class="form-control" id="vat" name="vat">
            </div>
            @endif
        </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3>{{ __('Other','sage') }}</h3>
            </div>
            @if($form==='participant')
            <div class="col-12 col-lg-4 form-group">
                <label for="profileImage">{{ __('Profile photo of the participant','sage') }}</label>
                <input type="file" class="form-control-file" id="profileImage" name="profileImage">
                <small id="profileImageHelp" class="form-text text-muted">{{ __('Minimum size - 400X500 px, Maximum filesize - 5mb','sage') }}</small>
                <div class="invalid-feedback">
                    {{ __('Please add file!','sage') }}
                </div>
            </div>
            @endif
            @if($form==='judge')
            <div class="col-12 col-lg-4 form-group">
                <label for="regalia" class="required">{{ __('Regalia','sage') }}</label>
                <textarea class="form-control" id="regalia" name="regalia" rows="5" required></textarea>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="profileImage">{{ __('Profile photo','sage') }}</label>
                <input type="file" class="form-control-file" id="profileImage" name="profileImage">
                <small id="profileImageHelp" class="form-text text-muted">{{ __('Minimum size - 400X500 px, Maximum filesize - 5mb','sage') }}</small>
                <div class="invalid-feedback">
                    {{ __('Please add file!','sage') }}
                </div>
            </div>
            @endif
            @if($form==='sponsor')
            @php
            $sponsor_packages = new WP_Query( array(
                    'post_type' => 'sponsor_package',
                    'posts_per_page' => -1,
                    'order' => 'ASC',
            ) );
            @endphp
            @if ( $sponsor_packages->have_posts() )
                <div class="col-12 col-lg-4 form-group">
                    <p>{{ __('Choose a package for cooperation','sage') }}</p>
                        @while ($sponsor_packages->have_posts()) @php $sponsor_packages->the_post(); global $post; $id = $post->ID; @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="packageRadios" id="package-{{ get_field('nr') }}" value="{{$id}}" >
                                <label class="form-check-label" for="package-{{ get_field('nr') }}">
                                    {{ esc_html( get_the_title() ) }}@if(!empty(get_field('price'))) - {{ get_field('price') }}€@endif
                                </label>
                            </div>
                        @endwhile
                    <p class="mt-3">

                        <a href="{{get_permalink(apply_filters( 'wpml_object_id', 703, 'post' ))}}" class="more" target="_blank">{{ __('More information about packages','sage') }}</a>
                    </p>
                    
                </div>
                @php wp_reset_postdata(); @endphp
            @else
            @endif @php wp_reset_query(); @endphp
            <div class="col-12 col-lg-4 form-group">
                <label for="companyLogo" class="required">{{ __('Company logo','sage') }}</label>
                <input type="file" class="form-control-file" id="companyLogo" name="companyLogo" required>
                <small id="profileImageHelp" class="form-text text-muted">{{ __('Maximum filesize - 5mb','sage') }}</small>
                <div class="invalid-feedback">
                    {{ __('Please add file!','sage') }}
                </div>
            </div>
            @endif
        </div>
</div>
