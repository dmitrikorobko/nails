{{--
  Template Name: Awards
--}}
@php



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


        //top participants

        $nominations = new WP_Query( array(
            'post_type' => 'nomination',
            'posts_per_page' => -1,
            'order' => 'ASC',

        ) );

        while ($nominations->have_posts()) {
            $nominations->the_post();
            $title = get_the_title();
            $nomination_id = get_the_id();

            $nominations_excl = get_field('nominations_excl', 1676);

            if (in_array($nomination_id, $nominations_excl))
                continue;



            $criteries = get_field('judging_criteria');

            if ($criteries)
                foreach ($criteries as $criteria) {

                    $nomination_scores = new WP_Query([
                        'post_type' => 'score',
                        'meta_key' => 'judging_criteria',
                        'meta_value' => $criteria,
                    ]);

                    if ($nomination_scores)
                        foreach ($nomination_scores->posts as $score) {
                            $score_criteria_id = get_field('judging_criteria', $score->ID);
                            $score_criteria = get_post($score_criteria_id[0]);


                            if (get_field('score', $score->ID) === 0)
                                continue;

                            //    print_r($score_criteria_id);
                            $participant = get_field('participant', $score->ID);
                            $team = get_field('team', 'user_'.$participant['ID']);
                            $division = get_field('division' ,'user_'.$participant['ID']);

                            $team_title = $team->post_title ?? 'Noteam';
                            $division_title = $division->post_title ?? 'Nodivision';

                           // $result[$nomination_id][$participant['ID']] += get_field('score', $score->ID)/get_nomination_maximum($nomination_id);
                            $nominations_total[$team_title][$division_title][$participant['ID']]   += get_field('score', $score->ID);


                        }


                }



        }

        foreach ($nominations_total as $team => $team_data) {
            foreach ($team_data as $division => $division_data) {

                 arsort($division_data);

                if (count($division_data) == 1)
                    continue;

                 if (count($division_data) > 3)
                     $division_data = array_slice($division_data, 0, 3, true);

                $total_team_trophy[$team]  = $division_data;
                $total_individual_trophy[$division] = $division_data;
            }
        }


        //Team Trophy


        $nominations = new WP_Query( array(
            'post_type' => 'nomination',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'fields' => 'ids',
            'post__not_in' => get_field('nominations_excl', 1676)
        ) );

//
//        echo '<pre>';
//
//        print_r($top_score);
//
//        echo '</pre>';


        $awards = new WP_Query( array(
            'post_type' => 'award',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'post__in' => [1117, 1272]
        ) );

        while ($awards->have_posts()) {
            $awards->the_post();
            $title = get_the_title();
            $nominations = get_field('nominations', get_the_id());

            foreach ($nominations as $nomination_id) {

                $nomination = get_post($nomination_id);
                $criteries = get_field('judging_criteria', $nomination);

                if ($criteries)
                foreach ($criteries as $criteria) {

                    $nomination_scores = new WP_Query([
                        'post_type' => 'score',
                        'meta_key' => 'judging_criteria',
                        'meta_value' => $criteria,
                    ]);

                    if ($nomination_scores)
                    foreach ($nomination_scores->posts as $score) {
                        $score_criteria_id = get_field('judging_criteria', $score->ID);
                        $score_criteria = get_post($score_criteria_id[0]);


                        if (get_field('score', $score->ID) === 0)
                            continue;

                    //    print_r($score_criteria_id);
                        $participant = get_field('participant', $score->ID);

                        $result[$title][$participant['ID']][$nomination_id] += get_field('score', $score->ID)/get_nomination_maximum($nomination_id);
                        $result_sum[$title][$participant['ID']][$nomination_id] += get_field('score', $score->ID);


                    }


                }

            }
            ?>


        <?php
        }

        foreach ($result as $award => $users) {
            foreach ($users as $user_id => $nominations) {

               arsort($nominations);

         //      foreach ($nominations as $nomination_id => )
                $nominations = array_slice($nominations, 0, 3, true);
                $result[$award][$user_id] =  ($nominations);

            }

        }


        function get_nomination_maximum($nomination_id) {
            $criteries =  get_field('judging_criteria', $nomination_id);
            foreach ($criteries as $criteria) {
                $max += get_field('point_max', $criteria);


            }

            return $max;
        }



//        echo '<pre>';
//
//        print_r($result);
//
//        echo '</pre>';


        echo '<h1 class="alert alert-danger heading">Team trophy</h1>';


        foreach ($total_team_trophy as $team => $team_data) {
            echo "<h2>$team</h2>";



                echo '<ol>';


                $i = 0;
                foreach ($team_data as $user_id => $item) {

                    $i++;

                    $user = get_userdata($user_id);

                    if ($i > 3)
                        continue;

                    echo "<li>{$user->display_name} <span class='badge  bg-warning text-dark'>$item</span>";

                    echo '</li>';

                }


                echo '</ol>';



        }


        echo '<h1 class="alert alert-danger heading">Ind trophy</h1>';


        foreach ($total_individual_trophy as $division => $team_data) {
            echo "<h2>$division</h2>";

            echo '<ol>';


            $i = 0;
            foreach ($team_data as $user_id => $item) {

                $i++;

                $user = get_userdata($user_id);

                if ($i > 3)
                    continue;

                echo "<li>{$user->display_name} <span class='badge  bg-warning text-dark'>$item</span>";

                echo '</li>';

            }


            echo '</ol>';

        }



        foreach ($result as $award => $items) {
            echo "<h1 class='alert alert-danger heading'>$award</h2>";

            echo '<ol>';

            arsort($items);
            $i = 0;
            foreach ($items as $user_id => $item) {

                $i++;

                $user = get_userdata($user_id);
               // $summ = array_sum($item);
                $summ = array_sum($result_sum[$award][$user_id]);



                if ($i > 3)
                    continue;

                echo "<li>{$user->display_name} <span class='badge  bg-warning text-dark'>$summ</span>";


                echo '</li>';

            }

            echo '</ol>';

        }


?>







@endsection
