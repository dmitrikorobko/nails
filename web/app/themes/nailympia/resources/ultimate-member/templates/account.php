<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">

	<div class="um-form">
	
		<form method="post" action="">
			
			<?php
			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_account_page_hidden_fields
			 * @description Show hidden fields on account form
			 * @input_vars
			 * [{"var":"$args","type":"array","desc":"Account shortcode arguments"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_account_page_hidden_fields', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_action( 'um_account_page_hidden_fields', 'my_account_page_hidden_fields', 10, 1 );
			 * function my_account_page_hidden_fields( $args ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( 'um_account_page_hidden_fields', $args ); ?>

			<div class="um-account-meta uimob340-show uimob500-show">

				<div class="um-account-meta-img">
					
						<?php 
						$image = get_field('field_60813af2e4e0e', 'user_'.um_user( 'ID' ).'');
						if( !empty( $image ) ): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						
						
						<?php 
					
						else: 
							echo get_avatar( um_user( 'ID' ), 120 );
						endif; ?>
		
				
				</div>

			</div>
			
			<div class="um-account-side uimob340-hide uimob500-hide">

				<div class="um-account-meta">

					<div class="um-account-meta-img uimob800-hide">
					
						<?php 
						$image = get_field('field_60813af2e4e0e', 'user_'.um_user( 'ID' ).'');
						if( !empty( $image ) ): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						
						
						<?php 
					
						else: 
							echo get_avatar( um_user( 'ID' ), 120 );
						endif; ?>
		
					
					</div>

					<?php if ( UM()->mobile()->isMobile() ) { ?>

						<div class="um-account-meta-img-b uimob800-show" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
					
						<?php 
						$image = get_field('field_60813af2e4e0e', 'user_'.um_user( 'ID' ).'');
						if( !empty( $image ) ): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						
						
						<?php 
					
						else: 
							echo get_avatar( um_user( 'ID' ), 120 );
						endif; ?>
		
				
						</div>

					<?php } else { ?>

						<div class="um-account-meta-img-b uimob800-show um-tip-<?php echo is_rtl() ? 'e' : 'w'; ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
				
						<?php 
						$image = get_field('field_60813af2e4e0e', 'user_'.um_user( 'ID' ).'');
						if( !empty( $image ) ): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						
						
						<?php 
					
						else: 
							echo get_avatar( um_user( 'ID' ), 120 );
						endif; ?>
		
					
						</div>

					<?php } ?>

				

				</div>

				<ul>
					<?php foreach ( UM()->account()->tabs as $id => $info ) {
						if ( isset( $info['custom'] ) || UM()->options()->get( "account_tab_{$id}" ) == 1 || $id == 'general' ) { ?>

							<li>
								<a data-tab="<?php echo esc_attr( $id )?>" href="<?php echo esc_url( UM()->account()->tab_link( $id ) ); ?>" class="um-account-link <?php if ( $id == UM()->account()->current_tab ) echo 'current'; ?>">
									<?php if ( UM()->mobile()->isMobile() ) { ?>
										<span class="um-account-icontip uimob800-show" title="<?php echo esc_attr( $info['title'] ); ?>">
											<i class="<?php echo esc_attr( $info['icon'] ); ?>"></i>
										</span>
									<?php } else { ?>
										<span class="um-account-icontip uimob800-show um-tip-<?php echo is_rtl() ? 'e' : 'w'; ?>" title="<?php echo esc_attr( $info['title'] ); ?>">
											<i class="<?php echo esc_attr( $info['icon'] ); ?>"></i>
										</span>
									<?php } ?>

									<span class="um-account-icon uimob800-hide">
										<i class="<?php echo esc_attr( $info['icon'] ); ?>"></i>
									</span>
									<span class="um-account-title uimob800-hide"><?php echo esc_html( $info['title'] ); ?></span>
									<span class="um-account-arrow uimob800-hide">
										<i class="<?php if ( is_rtl() ) { ?>um-faicon-angle-left<?php } else { ?>um-faicon-angle-right<?php } ?>"></i>
									</span>
								</a>
							</li>

						<?php }
					} ?>
				</ul>
			</div>
			
			<div class="um-account-main" data-current_tab="<?php echo esc_attr( UM()->account()->current_tab ); ?>">
			
				<?php
				/**
				 * UM hook
				 *
				 * @type action
				 * @title um_before_form
				 * @description Show some content before account form
				 * @input_vars
				 * [{"var":"$args","type":"array","desc":"Account shortcode arguments"}]
				 * @change_log
				 * ["Since: 2.0"]
				 * @usage add_action( 'um_before_form', 'function_name', 10, 1 );
				 * @example
				 * <?php
				 * add_action( 'um_before_form', 'my_before_form', 10, 1 );
				 * function my_before_form( $args ) {
				 *     // your code here
				 * }
				 * ?>
				 */
				do_action( 'um_before_form', $args );

			
				$user_id = um_user( 'ID' );
				$user_country = get_field('field_608e8353b5a19', 'user_'.$user_id.'');
				$team_object = get_field('field_609192499a8f9', 'user_'.$user_id.'');

				?>
				<section class="profile-info">
					<div class="row">
						<div class="col-12 main-info">
							<h3><? echo __('Information','sage')?></h3>
							<ul>
								<li><? echo __('Country','sage')?>: <?php echo $user_country;?></li>
								<li>ID: <?php echo $user_id; ?></li>
								<?php if($team_object) { ?>
									<li><? echo __('Team','sage')?>: <? echo $team_object->post_title; ?></li>
								<?php }?>
								
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-12 nominations">
							<h3><? echo __('Choosed nominations','sage')?></h3>
							<?php if( have_rows('field_608164444c690', 'user_'.$user_id.'') ): ?>

							<ul>

							<?php while( have_rows('field_608164444c690', 'user_'.$user_id.'') ): the_row(); ?>
								<?
								$nomination_id = get_sub_field('field_6081664d82734');
								?>
								<li>№<?echo get_field('number', $nomination_id);?> <?php echo get_the_title($nomination_id); ?></li>

							<?php endwhile; ?>

							</ul>

							<?php endif; ?>
						</div>
					</div>
				</section>
				<?php
				foreach ( UM()->account()->tabs as $id => $info ) {

					$current_tab = UM()->account()->current_tab;

					if ( isset( $info['custom'] ) || UM()->options()->get( 'account_tab_' . $id ) == 1 || $id == 'general' ) { ?>

						<div class="um-account-nav uimob340-show uimob500-show">
							<a href="javascript:void(0);" data-tab="<?php echo esc_attr( $id ); ?>" class="<?php if ( $id == $current_tab ) echo 'current'; ?>">
								<?php echo esc_html( $info['title'] ); ?>
								<span class="ico"><i class="<?php echo esc_attr( $info['icon'] ); ?>"></i></span>
								<span class="arr"><i class="um-faicon-angle-down"></i></span>
							</a>
						</div>

						<div class="um-account-tab um-account-tab-<?php echo esc_attr( $id ); ?>" data-tab="<?php echo esc_attr( $id  )?>">
							<?php $info['with_header'] = true;
							UM()->account()->render_account_tab( $id, $info, $args ); ?>
						</div>

					<?php }
				} ?>
				
			</div>
			<div class="um-clear"></div>
		</form>
		
		<?php
		/**
		 * UM hook
		 *
		 * @type action
		 * @title um_after_account_page_load
		 * @description After account form
		 * @change_log
		 * ["Since: 2.0"]
		 * @usage add_action( 'um_after_account_page_load', 'function_name', 10 );
		 * @example
		 * <?php
		 * add_action( 'um_after_account_page_load', 'my_after_account_page_load', 10 );
		 * function my_after_account_page_load() {
		 *     // your code here
		 * }
		 * ?>
		 */
		do_action( 'um_after_account_page_load' ); ?>

	</div>

</div>