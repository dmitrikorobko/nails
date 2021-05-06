<div class="userdata">
        <div class="row">
            <div class="col-12 heading">
                <h2><?php echo e(__('Information','sage')); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3><?php echo e(__('Naming','sage')); ?></h3>
            </div>
            <?php if($form==='participant'): ?>
                <?php
                $teams = new WP_Query( array(
                        'post_type' => 'team',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                ) );
                ?>	
                <div class="col-12 col-lg-4 form-group">
                    <label for="name" class="required"><?php echo e(__('Name and surname of the contestant','sage')); ?></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label for="team"><?php echo e(__('Team name, if any','sage')); ?></label>
                    <input type="text" class="form-control" id="team" name="team">
                </div>

                <?php if( $teams->have_posts() ): ?>
                    <data class="added-teams" value='{
                            <?php while($teams->have_posts()): ?> <?php $teams->the_post(); global $post; $id = $post->ID; ?>
                                "<?php echo e(esc_html( get_the_title() )); ?>" : "<?php echo e($id); ?>" <?php
                                if (get_next_post_link()) { 
                                    echo ','; 
                                }
                                ?>
                            <?php endwhile; ?>}'></data>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                <?php endif; ?> <?php wp_reset_query(); ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3><?php echo e(__('Address','sage')); ?></h3>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="address" class="required"><?php echo e(__('Address','sage')); ?></label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="country" class="required"><?php echo e(__('Country','sage')); ?></label>
                <select class="form-control selectpicker" id="country" name="country" data-country="<?php echo e(__('Estonia','sage')); ?>" required></select>
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="city" class="required"><?php echo e(__('City','sage')); ?></label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="postcode" class="required"><?php echo e(__('Postcode','sage')); ?></label>
                <input type="text" class="form-control" id="postcode" name="postcode"required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3><?php echo e(__('Contacts','sage')); ?></h3>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="phone" class="required"><?php echo e(__('Phone','sage')); ?></label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="email" class="required"><?php echo e(__('Email','sage')); ?></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="password1" class="required"><?php echo e(__('Password','sage')); ?></label>
                <input type="password" class="form-control" id="password1" name="password1" minlength="6" required>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="password2" class="required"><?php echo e(__('Repeat Password','sage')); ?></label>
                <input type="password" class="form-control" id="password2" name="password2" minlength="6" required>
                <div class="invalid-feedback">
                    <?php echo e(__('Passwords missmatch or length less than 6 characters','sage')); ?>

                </div>
            </div>
            <?php if($form==='participant' || 'judge'): ?>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="countryRepresent" class="required"><?php echo e(__('Country you will represent','sage')); ?></label>
                <select class="form-control selectpicker" id="countryRepresent" name="countryRepresent" data-country="<?php echo e(__('Estonia','sage')); ?>"></select>
            </div>
            <?php endif; ?>
        </div>
        <?php if($form==='participant' || 'sponsor'): ?>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3><?php echo e(__('Invoice','sage')); ?></h3>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="invoiceFor" class="required"><?php echo e(__('Invoice for','sage')); ?></label>
                <select class="form-control selectpicker" id="invoiceFor" name="invoiceFor">
                    <?php if($form==='participant'): ?>
                    <option value="private"><?php echo e(__('Private person','sage')); ?></option>
                    <?php endif; ?>
                    <option value="est-legal"><?php echo e(__('Estonian legal entity','sage')); ?></option>
                    <option value="eu-legal"><?php echo e(__('EU legal entity (VAT needed)','sage')); ?></option>
                    <option value="world-legal"><?php echo e(__('Legal entity outside EU','sage')); ?></option>
                </select>
            </div>
            <?php if($form==='participant'): ?>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional">
                <label for="invoiceCompany" class="required"><?php echo e(__('Company name','sage')); ?></label>
                <input type="text" class="form-control" id="invoiceCompany" name="invoiceCompany">
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional-reg">
                <label for="reg" class="required"><?php echo e(__('Registration number','sage')); ?></label>
                <input type="text" class="form-control" id="reg" name="reg">
            </div>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional-vat">
                <label for="vat" class="required"><?php echo e(__('VAT number','sage')); ?></label>
                <input type="text" class="form-control" id="vat" name="vat">
            </div>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional">
                <label for="invoiceCountry" class="required"><?php echo e(__('Country','sage')); ?></label>
                <select class="form-control selectpicker" id="invoiceCountry" name="invoiceCountry" data-country="<?php __('Estonia','sage') ?>"></select>
            </div>
            <div class="col-12 col-lg-4 d-sm-none d-md-flex">
            </div>
            <div class="col-12 col-lg-8 form-group hide" id="invoice-additional">
                <label for="invoiceAddressInfo" class="required"><?php echo e(__('Invoice Full Address and additional info','sage')); ?></label>
                <input type="text" class="form-control" id="invoiceAddressInfo" name="invoiceAddressInfo">
            </div>
            <?php endif; ?>
            <?php if($form==='sponsor'): ?>
            <div class="col-12 col-lg-4 form-group hide" id="invoice-additional-vat">
                <label for="vat" class="required"><?php echo e(__('VAT number','sage')); ?></label>
                <input type="text" class="form-control" id="vat" name="vat">
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h3><?php echo e(__('Other','sage')); ?></h3>
            </div>
            <?php if($form==='participant'): ?>
            <div class="col-12 col-lg-4 form-group">
                <label for="profileImage" class="required"><?php echo e(__('Profile photo of the participant','sage')); ?></label>
                <input type="file" class="form-control-file" id="profileImage" name="profileImage" required>
                <small id="profileImageHelp" class="form-text text-muted"><?php echo e(__('Minimum size - 400X500 px, Maximum filesize - 5mb','sage')); ?></small>
                <div class="invalid-feedback">
                    <?php echo e(__('Please add file!','sage')); ?>

                </div>
            </div>
            <?php endif; ?>
            <?php if($form==='judge'): ?>
            <div class="col-12 col-lg-4 form-group">
                <label for="regalia" class="required"><?php echo e(__('Regalia','sage')); ?></label>
                <textarea class="form-control" id="regalia" rows="3" required></textarea>
            </div>
            <div class="col-12 col-lg-4 form-group">
                <label for="profileImage" class="required"><?php echo e(__('Profile photo','sage')); ?></label>
                <input type="file" class="form-control-file" id="profileImage" name="profileImage" required>
                <small id="profileImageHelp" class="form-text text-muted"><?php echo e(__('Minimum size - 400X500 px, Maximum filesize - 5mb','sage')); ?></small>
            </div>
            <?php endif; ?>
            <?php if($form==='sponsor'): ?>
            <?php
            $sponsor_packages = new WP_Query( array(
                    'post_type' => 'sponsor_package',
                    'posts_per_page' => -1,
                    'order' => 'ASC',
            ) );
            ?>
            <?php if( $sponsor_packages->have_posts() ): ?>
                <div class="col-12 col-lg-4 form-group">
                    <p><?php echo e(__('Choose a package for cooperation','sage')); ?></p>
                        <?php while($sponsor_packages->have_posts()): ?> <?php $sponsor_packages->the_post(); global $post; $id = $post->ID; ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="packageRadios" id="package-<?php echo e(get_field('nr')); ?>" value="<?php echo e($id); ?>" >
                                <label class="form-check-label" for="package-<?php echo e(get_field('nr')); ?>">
                                    <?php echo e(esc_html( get_the_title() )); ?>

                                </label>
                            </div>
                        <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
            <?php endif; ?> <?php wp_reset_query(); ?>
            <div class="col-12 col-lg-4 form-group">
                <label for="companyLogo" class="required"><?php echo e(__('Company logo','sage')); ?></label>
                <input type="file" class="form-control-file" id="companyLogo" name="companyLogo" required>
                <small id="profileImageHelp" class="form-text text-muted"><?php echo e(__('Maximum filesize - 5mb','sage')); ?></small>
            </div>
            <?php endif; ?>
        </div>
</div>
