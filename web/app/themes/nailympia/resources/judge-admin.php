 <?php

    $user_id = $args['user_id']; ?>


 <div class="col-sm-12">
    <form class="judge_admin_form">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="participant">
                        <strong>Participant</strong>
                        <?php wp_dropdown_users( ['class'=>'form-control', 'role'=>'participant', 'name' => 'participant', 'show_option_none'   => 'Select',] ); ?>
                    </label>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="user_nominations preloader">

                </div>
            </div>

            <div class="col-sm-12">
                <div class="nominations_criteries preloader">

                </div>
            </div>



        </div>










        <button id="submit" name="form" type="submit" class="btn btn-primary">Submit</button>


        <input type="hidden" name="action" value="judge_admin_form">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">


        <div class="result"></div>


    </form>
</div>