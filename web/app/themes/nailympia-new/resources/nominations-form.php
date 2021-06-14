<form  class="user_nominations_form">


    <?php

    $user_id = $args['user_id'];
    $user_invoice = $args['user_invoice'];

    $loop = 0;

    if( have_rows('field_608164444c690', 'user_'.$user_id.'') ): ?>
        <div class="col-12 nominations">
            <h3><? echo __('Choosed nominations','sage')?></h3>

            <ul>

                <?php while( have_rows('field_608164444c690', 'user_'.$user_id.'') ): the_row(); ?>
                    <?
                    $nomination_id = get_sub_field('field_6081664d82734');
                    $video_active = get_sub_field('field_608168e9562ae');
                    $video = get_sub_field('field_608168fd562af');


                    $image_active = get_sub_field('field_60816812e7ea5');

                    $image = get_sub_field('gallery')[0];

                    $online_url_active =  get_sub_field('field_60816945c3988');
                    $activate_upload = sliced_get_invoice_status($user_invoice->ID) == "paid" ? true : false;

                    ?>
                    <li data-loop="<?= $loop ?>">

                        <div class="name">
                            <?if($activate_upload){?><h4><?}?>№<?echo get_field('number', $nomination_id);?> <?php echo get_the_title($nomination_id); ?><?if($activate_upload){?></h4><?}?>
                        </div>

                        <?if($image_active && $activate_upload){ ?>
                            <div class="contest contestImage">


                                <input type="hidden" class="dz-image<?= $loop ?>" name="data[<?= $nomination_id ?>][image]" value="<?= $image['ID'] ?>">


                                <div class="media-item">
											<span class="custom-file-preview-del <?= $image ? '' : 'hidden' ?>">
												<svg class="icon"><use xlink:href="#ic-close"></use></svg>
											</span>

                                    <img data-src="<?= $image ? $image['url'] : '' ?>" class="image_uploaded-image image_uploaded-image<?= $loop ?> image <?= $image ? '' : 'hidden' ?>" src="<?= $image ? $image['sizes']['medium'] : '' ?>" alt="">

                                    <button class="file-upload">
                                        <div  data-type="image"  class=" file-input"  ></div>
                                    </button>
                                    <svg class="icon add-img"> <use xlink:href="#ic-photo"></use></svg>
                                    <svg class="icon-plus add-img"> <use xlink:href="#ic-plus"></use></svg>
                                </div>
                                <h4><? echo __('Add image file','sage') ?></h4>
                            </div>
                        <?}?>
                        <?if($video_active && $activate_upload){

                              

                            ?>
                            <div class="contest contestVideo">

                                <input type="hidden" value="><?= $video['ID'] ?>" class="dz-video<?= $loop ?>" name="data[<?= $nomination_id ?>][video]">
                                <div class="image_uploaded-video image_uploaded-video<?= $loop ?>" >





                                </div>


                                <div class="media-item">
											<span class="custom-file-preview-del <?= $video ? '' : 'hidden' ?>">
												<svg class="icon"><use xlink:href="#ic-close"></use></svg>
											</span>

                                    <img data-src="<?= $video ? $video['url'] : ''    ; ?>" class="image_uploaded-image image_uploaded-image<?= $loop ?>  image <?= $video ? '' : 'hidden' ?>" src="/wp-content/uploads/2021/06/video-placeholder-brain-bites.png" alt="">
                                    <button class="file-upload">
                                        <div data-type="video" class="file-input video dropzones" ></div>
                                    </button>
                                    <svg class="icon add-img" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 332.804 332.804" style="enable-background:new 0 0 332.804 332.804;" xml:space="preserve">
<g>
    <g>
        <g>
            <path d="M330.804,171.002c-3.6-6.4-12-8.8-18.8-4.8l-45.6,26.4l-11.6,6.8v63.2l10.8,6.4c0.4,0,0.4,0.4,0.8,0.4l44.8,26
				c2,1.6,4.8,2.4,7.6,2.4c7.6,0,13.6-6,13.6-13.6v-53.6l0.4-52.8C332.804,175.402,332.404,173.002,330.804,171.002z"/>
            <path d="M64.404,150.602c35.6,0,64.4-28.8,64.4-64.4c0-35.6-28.8-64.4-64.4-64.4s-64.4,28.8-64.4,64.4
				C-0.396,121.802,28.804,150.602,64.404,150.602z M64.404,59.802c14.8,0,26.4,12,26.4,26.4c0,14.8-12,26.4-26.4,26.4
				c-14.4,0-26.4-12-26.4-26.4C37.604,71.402,49.604,59.802,64.404,59.802z"/>
            <path d="M227.604,154.202c-10.4,5.2-22,8.4-34.4,8.4c-15.2,0-29.6-4.4-41.6-12.4h-45.6c-12,8-26.4,12.4-41.6,12.4
				c-12.4,0-24-2.8-34.4-8.4c-9.2,5.2-15.6,15.6-15.6,26.8v97.6c0,18,14.8,32.4,32.4,32.4h164.4c18,0,32.4-14.8,32.4-32.4v-97.6
				C243.204,169.802,236.804,159.402,227.604,154.202z"/>
            <path d="M193.204,150.602c35.6,0,64.4-28.8,64.4-64.4c0-35.6-28.8-64.4-64.4-64.4c-35.6,0-64.4,28.8-64.4,64.4
				C128.804,121.802,157.604,150.602,193.204,150.602z M193.204,59.802c14.8,0,26.4,12,26.4,26.4c0,14.8-12,26.4-26.4,26.4
				c-14.4,0-26.4-12-26.4-26.4C166.804,71.402,178.404,59.802,193.204,59.802z"/>
        </g>
    </g>
</g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
</svg>


                                    <svg class="icon-plus add-img"> <use xlink:href="#ic-plus"></use></svg>
                                </div>
                                <h4><? echo __('Add video file','sage') ?></h4>

                            </div>
                        <?}?>

                    </li>

                    <?php $loop++ ?>

                <?php endwhile; ?>

            </ul>

        </div>


        <button id="submit" name="form" type="submit" class="btn">Submit</button>

        <input type="hidden" name="action" value="user_nominations_form">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <?php endif; ?>


    <div class="preloader"></div>

</form>
