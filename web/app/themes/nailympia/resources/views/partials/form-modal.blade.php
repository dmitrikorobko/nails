<div class="modal registration modal-fullscreen" id="modalRegistration" tabindex="-1" role="dialog" aria-labelledby="registrationSuccess" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="header">
                    <button class="menu-close btn transperent" data-dismiss="modal" aria-label="Close">
                        <img src="<?= ASSETS; ?>images/menu_close.svg" class="menu_close">
                    </button>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center mb-5">
                            <h2 class="reg-success">{{ __('Thank you for registration','sage') }}</h2>
                            <h2 class="reg-wrong hide">{{ __('Something went wrogn!','sage') }}</h2>
                            <div class="reg-message">
                            @if($form==='participant')
                                @option('reg_participant_text')
                            @elseif($form==='judge')
                                @option('reg_judge_text')
                            @elseif($form==='sponsor')
                                @option('reg_sponsor_text')
                            @endif
                            <a class="login btn red mt-4" href="<?php echo esc_url(um_get_core_page( 'login' ));  ?>" id="modalLogin">{{ __('Personal area','sage') }}</a>
                            </div>
                            <div class="reg-error-message hide">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>