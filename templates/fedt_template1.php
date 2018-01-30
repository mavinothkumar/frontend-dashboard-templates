<?php

$dashboard_container = new FED_Routes( $_REQUEST );
$menu                = $dashboard_container->setDashboardMenuQuery();

$column = 'col-md-12';
if ( is_active_sidebar( 'fed_dashboard_right_sidebar' ) ) {
	$column = 'col-md-9';
}
$logo = fedt_get_website_logo();

do_action( 'fed_before_dashboard_container' );
?>
	<div class="bc_fed fed_dashboard_container">
		<?php echo fed_loader() ?>
		<?php if ( ! $menu instanceof WP_Error ) { ?>
			<div class="row fed_dashboard_wrapper">
				<div class="col-md-2 fed_dashboard_menus fed_template1">
					<div class="custom-collapse fed_menu_items">
						<button class="bg_secondary collapse-toggle visible-xs collapsed" type="button" data-toggle="collapse" data-parent="custom-collapse" data-target="#fed_template1_template">
							<span class=""><i class="fa fa-bars"></i></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<ul class="list-group fed_menu_ul collapse" id="fed_template1_template">
							<li class="list-group-item fedt_profile_picture">
								<div class="text-center menu_image_container">
									<div class="menu_image">
										<?php echo fed_get_avatar( get_current_user_id(), '', 'image-responsive img-circle', 'width=150px' ) ?>
									</div>
									<div class="user_name text-uppercase">
										<?php echo fed_get_display_name_by_id( get_current_user_id() ) ?>
									</div>
								</div>
							</li>
							<?php
							fed_display_dashboard_menu( $menu );

							fed_get_collapse_menu() ?>
						</ul>
					</div>
				</div>
				<div class="col-md-10 fed_dashboard_items">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-7">
							<?php echo $logo; ?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-5">
							<div class="pull-right"></div>
						</div>
					</div>
					<div class="row">
						<div class="<?php echo $column; ?>">
							<?php
							$dashboard_container->getDashboardContent( $menu );
							?>
						</div>
						<?php if ( is_active_sidebar( 'fed_dashboard_right_sidebar' ) ) { ?>
							<div class="col-md-3 fed_ads">
								<div class="bc_fed widget-area" role="complementary">
									<?php dynamic_sidebar( 'fed_dashboard_right_sidebar' ); ?>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>
			</div>
		<?php }
		if ( $menu instanceof WP_Error ) {
			?>
			<div class="row fed_dashboard_wrapper fed_error">
				<?php fed_get_403_error_page() ?>
			</div>
			<?php
		} ?>
	</div>
<?php
do_action( 'fed_after_dashboard_container' );