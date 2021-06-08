<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$user_id = um_user( 'ID' );
$user_meta=get_userdata($user_id);
$user_roles=$user_meta->roles;
$user_role = $user_roles[0];
$user_invoice = false;
$is_participant = ($user_role == "participant") ? true : false;
$is_judge = ($user_role == "judge") ? true : false;
$is_sponsor = ($user_role == "sponsor") ? true : false;

$user_country = get_field('field_608e8353b5a19', 'user_'.$user_id.'');
$team_object = get_field('field_609192499a8f9', 'user_'.$user_id.'');

$package_object = get_field('field_609540d373261', 'user_'.$user_id.'');

$image = get_field('field_60813af2e4e0e', 'user_'.um_user( 'ID' ).'');

if ($is_sponsor){
	$image = get_field('field_608199fdbbf29', 'user_'.um_user( 'ID' ).'');
}

if ($is_participant || $is_sponsor){
	$user_invoice = get_field('field_60819a5fbfc6c', 'user_'.$user_id.'');
}

?>

<div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">

	<div class="um-form">

		
			
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
			?>

			<div class="um-account-meta uimob340-show uimob500-show">

				<div class="um-account-meta-img">
					
						<?php 
						if( !empty( $image ) ): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						
						
						<?php 
					
						else: 
							echo get_avatar( um_user( 'ID' ), 120 );
						endif; ?>
		
				
				</div>

				<?if($is_judge) {?>
				<div class="evaluation-criteria">
					<?php the_field('field_6097e9d5fb937', 'option'); ?>
				</div>
				<?}?>

			</div>
			
			<div class="um-account-side uimob340-hide uimob500-hide">

				<div class="um-account-meta">

					<div class="um-account-meta-img uimob800-hide">
					
						<?php 
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
				<?if($is_judge) {?>
				<div class="evaluation-criteria">
					<?php the_field('field_6097e9d5fb937', 'option'); ?>
				</div>
				<?}?>
			</div>
			
			<div class="um-account-main" data-current_tab="<?php echo esc_attr( UM()->account()->current_tab ); ?>">
			
					<section class="profile-info">
					<div class="row">
						<div class="col-12 main-info">
							<h3><? echo __('Information','sage')?></h3>
							<?if($is_participant || $is_judge) {?>
							<ul>
								<li><? echo __('Country','sage')?>: <?php echo $user_country;?></li>
								<li>ID: <?php echo $user_id; ?></li>
								<?php if($team_object) { ?>
									<li><? echo __('Team','sage')?>: <? echo $team_object->post_title; ?></li>
								<?php }?>
								<?if($is_participant && $user_invoice) {?>
									<li class="invoice"><img src="<?= ASSETS; ?>/images/invoice.svg"><a href="<?echo get_permalink($user_invoice->ID)?>" target="_blank"><? echo __('Invoice','sage')?></a></li>
								<?}?>
							</ul>
							<?}?>
							<?if($is_sponsor) {?>
								<ul>
								<li><? echo __('Package','sage')?>: №<? echo get_field('field_60819d4c93b11', $package_object->ID)?> - <?php echo $package_object->post_title;?></li>
								<li><? echo __('Package Price','sage')?>: <?php echo get_field('field_60819d6393b13', $package_object->ID)?>€</li>
								<?if($user_invoice) {?>
									<li class="invoice"><img src="<?= ASSETS; ?>/images/invoice.svg"><a href="<?echo get_permalink($user_invoice->ID)?>" target="_blank"><? echo __('Invoice','sage')?></a></li>
								<?}?>
								</ul>
							<?}?>
						</div>
						<?if($is_sponsor) {?>
						<div class="col-12 main-info">
						<h3><? echo __('Description','sage')?></h3>
							<? the_field('field_60819d5493b12', $package_object->ID)				
							?>
						</div>
						<?}?>
					</div>
					<div class="row">
						<?/*if($is_judge){?>
						<div class="col-12 regalia">
							<h3><? echo __('Description','sage')?></h3>
							<?php $options = array(
								'post_id' => 'user_'.$user_id,
								'fields' => array('field_6081a017220dd'),
								'form' => true, 
								'return' => add_query_arg( 'updated', 'true', get_permalink() ), 
								'html_before_fields' => '',
								'html_after_fields' => '',
								'html_submit_button'  => '<input type="submit" class="acf-button um-button" value="%s" />',
								'submit_value' => __( 'Update Account', 'ultimate-member' ) 
							);
							acf_form( $options );
							?>
						</div>
						<?}*/?>
						<?php if( have_rows('field_608164444c690', 'user_'.$user_id.'') ): ?>
						<div class="col-12 nominations">
							<h3><? echo __('Choosed nominations','sage')?></h3>

							<ul>

							<?php while( have_rows('field_608164444c690', 'user_'.$user_id.'') ): the_row(); ?>
								<?
								$nomination_id = get_sub_field('field_6081664d82734');
								$video_active = get_sub_field('field_608168e9562ae');
								$image_active = get_sub_field('field_60816812e7ea5');
								$online_url_active =  get_sub_field('field_60816945c3988');
								$activate_upload = sliced_get_invoice_status($user_invoice->ID) == "paid" ? true : false;
							
								?>
								<li>

									<div class="name">
										<?if($activate_upload){?><h4><?}?>№<?echo get_field('number', $nomination_id);?> <?php echo get_the_title($nomination_id); ?><?if($activate_upload){?></h4><?}?>
									</div>
									
									<?if($image_active && $activate_upload){ ?>
									<div class="contestImage">
										
										<div class="media-item">
											<span class="custom-file-preview-del hidden">
												<svg class="icon"><use xlink:href="#ic-close"></use></svg>
											</span>
											<img class="image hidden" src="" alt="">
											<button class="file-upload"> 
												<input type="file" class="file-input" name="file[]"> 
											</button> 
											<svg class="icon add-img"> <use xlink:href="#ic-photo"></use></svg>
											<svg class="icon-plus add-img"> <use xlink:href="#ic-plus"></use></svg>
										</div>
										<h4><? echo __('Add image file','sage') ?></h4>
									</div>
									<?}?>
									<?if($video_active && $activate_upload){ ?>
									<div class="contestVideo">
										<div class="media-item">
											<span class="custom-file-preview-del hidden">
												<svg class="icon"><use xlink:href="#ic-close"></use></svg>
											</span>
											<img class="image hidden" src="" alt="">
											<button class="file-upload"> 
												<input type="file" class="file-input" name="file[]"> 
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

							<?php endwhile; ?>

							</ul>

						</div>
						<?php endif; ?>
					</div>
				</section>
				<div class="hidden"> 
					<xml version="1.0" encoding="utf-8" ?="">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<symbol viewBox="0 0 32 32" id="ic-close" xmlns="http://www.w3.org/2000/svg"><path d="M3 29.163L29.163 3M2.121 3l26.163 26.163"></path></symbol>
						<symbol viewBox="0 0 63 51" id="ic-photo" xmlns="http://www.w3.org/2000/svg"><path d="M31.5 19.2a9.45 9.45 0 00-9.45 9.45 9.45 9.45 0 109.45-9.45zm25.2-9.45h-7.56c-1.04 0-2.16-.806-2.488-1.793l-1.954-5.865C44.368 1.106 43.249.3 42.21.3H20.79c-1.04 0-2.16.806-2.488 1.793l-1.954 5.865c-.33.986-1.448 1.792-2.488 1.792H6.3c-3.465 0-6.3 2.835-6.3 6.3V44.4c0 3.465 2.835 6.3 6.3 6.3h50.4c3.465 0 6.3-2.835 6.3-6.3V16.05c0-3.465-2.835-6.3-6.3-6.3zM31.5 44.4c-8.698 0-15.75-7.051-15.75-15.75 0-8.698 7.052-15.75 15.75-15.75 8.697 0 15.75 7.052 15.75 15.75 0 8.699-7.053 15.75-15.75 15.75zm22.995-23.944a2.205 2.205 0 110-4.41 2.205 2.205 0 010 4.41z"></path></symbol>
						<symbol viewBox="0 0 26 26" id="ic-plus" xmlns="http://www.w3.org/2000/svg"><path d="M2 12.634h22M13.006 2v22"></path></symbol>
						</svg>
					</xml>
				</div>
				<form method="post" action="">

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
				do_action( 'um_account_page_hidden_fields', $args ); 
				do_action( 'um_before_form', $args );

				?>
				
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
					</form>
			</div>
			<div class="um-clear"></div>
	
		
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