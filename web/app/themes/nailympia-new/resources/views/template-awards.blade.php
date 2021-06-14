{{--
  Template Name: Awards
--}}
@php

    $awards = new WP_Query( array(
            'post_type' => 'award',
            'posts_per_page' => -1,
            'order' => 'ASC',
    ) );

@endphp

@extends('layouts.app')
@section('content')


    @include('partials.page-header')
    @include('partials.content-page')


    <table class="table">
        <tr>
            <th>Award</th>

        </tr>
    </table>
        <?php

        while ($awards->have_posts()) {
            $awards->the_post();

            $title = get_the_title();

            $nominations = get_field('nominations', get_the_id());



            foreach ($nominations as $nomination_id) {

                $nomination = get_post($nomination_id);

                $criteries = get_field('judging_criteria', $nomination);

                foreach ($criteries as $criteria) {

                    $nomination_scores = new WP_Query([
                        'post_type' => 'score',
                        'meta_key' => 'judging_criteria',
                        'meta_value' => $criteria,
                    ]);

                    foreach ($nomination_scores->posts as $score) {
                        $score_criteria_id = get_field('judging_criteria', $score->ID);
                        $score_criteria = get_post($score_criteria_id[0]);

                    //    print_r($score_criteria_id);


                        $participant = get_field('participant', $score->ID);
                        $result[$title][$nomination->post_title][$participant['display_name']]+= get_field('score', $score->ID);
                    }


                }

            }
            ?>


        <?php
        }


        echo '<pre>';

        print_r($result);

        echo '</pre>';
?>







@endsection
