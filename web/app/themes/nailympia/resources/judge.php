    <?php

$user_id = $args['user_id']; ?>

<div class="col-sm-12">
    <form class="judge_form">

        <table class="table">
            <tr>
                <th><?php _e('Participant', 'sage') ?></th>
                <th><?php _e('Nomination', 'sage') ?></th>
                <th><?php _e('Criteria', 'sage') ?></th>
                <th><?php _e('Works', 'sage') ?></th>
                <th><?php _e('Score', 'sage') ?></th>
                <th></th>
            </tr>
            
            <?php 
            $q = new WP_Query([
                'post_type' => 'score',
                'meta_key' => 'judge',
                'meta_value' => $user_id,
                'posts_per_page' => -1
            ]);
            
            if ($q->have_posts()) {
                while ($q->have_posts()) {
                    $q->the_post();
                    $participant = get_field('participant');
                    $judging_criteria_id = get_field('judging_criteria')[0];


                   // print_r($judging_criteria_id);

                    $judging_criteria = get_post($judging_criteria_id);




                    $nomination = get_field('nomination');

                    ?>
                    <tr>
                        <td><?= $participant['ID'] ?></td>
                        <td><?= get_post($nomination)->post_title ?></td>
                        <td>
                            <?= $judging_criteria->post_title ?>
                        </td>
                        <td>



                        <?php

                            $image = '';
                            foreach (get_field('nominations','user_'.$participant['ID'] ) as $row) {
                                if ($nomination == $row['nomination']) {
                                    $image = $row['gallery'][0];
                                    $video = $row['video'];

                                  //  print_r($image);
                                }


                            }

                            if ($image) { ?>

                                <a href="<?= $image['url'] ?>" class="fancybox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                    </svg>
                                </a>

                            <?php }

                            if ($video) { ?>

                                <a href="<?= $video['url'] ?>" class="fancybox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-reels-fill" viewBox="0 0 16 16">
                                        <path d="M6 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        <path d="M9 6a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        <path d="M9 6h.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h7z"/>
                                    </svg>
                                </a>

                            <?php } ?>


                        </td>



                        <td>

                            <?php if (get_field('score')) { ?>

                                <strong><?= get_field('score') ?></strong>

                            <?php } else {

                                 $point = get_field('point', $judging_criteria_id);

                                ?>

                                <select name="score" class="form-control">
                                    <option value=""><?php _e('Select', 'sage') ?></option>
                                    <?php foreach (range($point['min'], $point['max']) as $score) {  ?>
                                        <option value="<?= $score ?>"><?= $score ?></option>
                                    <?php } ?>
                                </select>

                            <?php } ?>
                        </td>

                        <td class="text-center align-middle"><button
                                <?php if (get_field('score')) { ?>
                                    disabled
                                <?php } ?>
                                class="btn btn-danger set_score" data-post_id="<?php the_id() ?>"><?php _e('Set score', 'sage') ?></button> </td>
                    </tr>
                    <?php
                }
            }
            ?>
            
            
        </table>







        <div class="result"></div>


    </form>
</div>