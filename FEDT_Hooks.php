<?php

/**
 * Body Background Color
 * Sidebar Color
 * Content Color
 * Content Body Color
 * Ads Color
 *
 * Website Logo
 *
 */


if ( ! class_exists( 'FEDT_Hooks' ) ) {
	class FEDT_Hooks {
		public function __construct() {
			add_filter( 'frontend-dashboard_template_paths', array( $this, 'add_template_part' ), 30 );
			add_filter( 'fed_plugin_versions', array( $this, 'fedt_plugin_versions' ) );
			add_filter( 'show_admin_bar', array( $this, 'fedt_remove_admin_bar' ) );
			add_filter( 'widgets_init', array( $this, 'fedt_widgets_init' ) );
			add_filter( 'fed_change_author_frontend_page', array( $this, 'fedt_change_author_frontend_page' ) );
			add_filter( 'fed_admin_upl_colors_template', array( $this, 'fedt_admin_upl_colors_template' ), 10, 2 );
			add_filter( 'fed_admin_settings_upl_color', array( $this, 'fedt_admin_settings_upl_color' ), 10, 2 );
			add_filter( 'fed_add_inline_css_at_head', array( $this, 'fedt_add_inline_css_at_head' ) );
			add_filter( 'fed_admin_settings_upl', array( $this, 'fedt_admin_settings_upl' ), 10, 2 );
			add_filter( 'fed_admin_upl_settings_template', array( $this, 'fedt_admin_upl_settings_template' ), 10, 2 );

			//add_action( 'fed_before_login_form', array( $this, 'fedt_before_login_form' ) );
		}

		public function fedt_before_login_form() {
			?>
			<div class="bc_fed container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 flex-center">
						<?php echo fedt_get_website_logo(); ?>
					</div>
				</div>
			</div>
			<?php
		}

		public function fedt_admin_settings_upl( $fed_admin_settings_upl, $request ) {
			$fed_admin_settings_upl['settings']['fed_upl_website_logo']        = isset( $request['settings']['fed_upl_website_logo'] ) ? (int) $request['settings']['fed_upl_website_logo'] : null;
			$fed_admin_settings_upl['settings']['fed_upl_website_logo_width']  = isset( $request['settings']['fed_upl_website_logo_width'] ) ? (int) $request['settings']['fed_upl_website_logo_width'] : '';
			$fed_admin_settings_upl['settings']['fed_upl_website_logo_height'] = isset( $request['settings']['fed_upl_website_logo_height'] ) ? (int) $request['settings']['fed_upl_website_logo_height'] : '100';
			$fed_admin_settings_upl['settings']['fed_upl_template_model']      = isset( $request['settings']['fed_upl_template_model'] ) ? $request['settings']['fed_upl_template_model'] : 'default';
			$fed_admin_settings_upl['settings']['fed_upl_hide_admin_bar']      = isset( $request['settings']['fed_upl_hide_admin_bar'] ) ? $request['settings']['fed_upl_hide_admin_bar'] : 'default';

			return $fed_admin_settings_upl;
		}

		public function fedt_admin_upl_settings_template( $array, $fed_admin_options ) {
			if ( defined( 'BC_FED_EXTRA_PLUGIN_VERSION' ) ) {
				$array['input']['Website Logo']        = array(
					'col'   => 'col-md-12',
					'name'  => __( 'Website Logo', 'frontend-dashboard-templates' ),
					'input' => fed_get_input_details( array(
						'input_meta' => 'settings[fed_upl_website_logo]',
						'user_value' => isset( $fed_admin_options['settings']['fed_upl_website_logo'] ) ? $fed_admin_options['settings']['fed_upl_website_logo'] : null,
						'input_type' => 'file'
					) )
				);
				$array['input']['Website Logo Width']  = array(
					'col'   => 'col-md-6',
					'name'  => __( 'Website Logo Width (px)', 'frontend-dashboard-templates' ),
					'input' => fed_get_input_details( array(
						'input_meta' => 'settings[fed_upl_website_logo_width]',
						'user_value' => isset( $fed_admin_options['settings']['fed_upl_website_logo_width'] ) ? $fed_admin_options['settings']['fed_upl_website_logo_width'] : null,
						'input_type' => 'number'
					) )
				);
				$array['input']['Website Logo height'] = array(
					'col'   => 'col-md-6',
					'name'  => __( 'Website Logo Height (px)', 'frontend-dashboard-templates' ),
					'input' => fed_get_input_details( array(
						'input_meta' => 'settings[fed_upl_website_logo_height]',
						'user_value' => isset( $fed_admin_options['settings']['fed_upl_website_logo_height'] ) ? $fed_admin_options['settings']['fed_upl_website_logo_height'] : null,
						'input_type' => 'number'
					) )
				);

				$array['input']['Template Model'] = array(
					'col'   => 'col-md-6',
					'name'  => __( 'Template Model', 'frontend-dashboard-templates' ),
					'input' => fed_get_input_details( array(
						'input_meta'  => 'settings[fed_upl_template_model]',
						'input_value' => array( 'default' => 'Default', 'template1' => 'Template 1' ),
						'user_value'  => isset( $fed_admin_options['settings']['fed_upl_template_model'] ) ? $fed_admin_options['settings']['fed_upl_template_model'] : 'default',
						'input_type'  => 'select'
					) )
				);

				$array['input']['Hide Admin Menu Bar'] = array(
					'col'   => 'col-md-6',
					'name'  => __( 'Hide Admin Menu Bar', 'frontend-dashboard-templates' ),
					'input' => fed_get_input_details( array(
						'input_meta'  => 'settings[fed_upl_hide_admin_bar]',
						'input_value' => fed_yes_no( 'ASC' ),
						'user_value'  => isset( $fed_admin_options['settings']['fed_upl_hide_admin_bar'] ) ? $fed_admin_options['settings']['fed_upl_hide_admin_bar'] : '',
						'input_type'  => 'select'
					) )
				);
			} else {
				$array['input']['Website Logo'] = array(
					'col'   => 'col-md-12',
					'name'  => __( 'Website Logo', 'frontend-dashboard-templates' ),
					'input' => '<br>Please install <a href="https://buffercode.com/plugin/frontend-dashboard-extra">Frontend Dashboard Extra plugin</a> to upload logo'
				);
			}

			return $array;
		}

		public function fedt_admin_upl_colors_template( $array, $fed_admin_options ) {
			$array['input']['Body Background Color'] = array(
				'col'          => 'col-md-6',
				'name'         => __( 'Body Background Color', 'frontend-dashboard-templates' ),
				'input'        => fed_get_input_details( array(
					'input_meta' => 'color[fed_upl_color_bbg_color]',
					'user_value' => isset( $fed_admin_options['color']['fed_upl_color_bbg_color'] ) ? $fed_admin_options['color']['fed_upl_color_bbg_color'] : '#033333',
					'input_type' => 'color'
				) ),
				'help_message' => fed_show_help_message( array( 'content' => __( 'Default Body Background Color #033333', 'frontend-dashboard-templates' ) ) )
			);

			$array['input']['Content Background Color'] = array(
				'col'          => 'col-md-6',
				'name'         => __( 'Content Background Color', 'frontend-dashboard-templates' ),
				'input'        => fed_get_input_details( array(
					'input_meta' => 'color[fed_upl_color_cbg_color]',
					'user_value' => isset( $fed_admin_options['color']['fed_upl_color_cbg_color'] ) ? $fed_admin_options['color']['fed_upl_color_cbg_color'] : '#f3f3f3',
					'input_type' => 'color'
				) ),
				'help_message' => fed_show_help_message( array(
					'content' => __( 'Default Content Background Color #f3f3f3' ),
					'frontend-dashboard-templates'
				) )
			);

			$array['input']['Widget Background Color'] = array(
				'col'          => 'col-md-6',
				'name'         => __( 'Widget Background Color', 'frontend-dashboard-templates' ),
				'input'        => fed_get_input_details( array(
					'input_meta' => 'color[fed_upl_color_wbg_color]',
					'user_value' => isset( $fed_admin_options['color']['fed_upl_color_wbg_color'] ) ? $fed_admin_options['color']['fed_upl_color_wbg_color'] : '#f3f3f3',
					'input_type' => 'color'
				) ),
				'help_message' => fed_show_help_message( array( 'content' => __( 'Default Widget Background Color #f3f3f3', 'frontend-dashboard-templates' ) ) )
			);

			$array['input']['Panel Background Color'] = array(
				'col'          => 'col-md-6',
				'name'         => __( 'Panel Background Color', 'frontend-dashboard-templates' ),
				'input'        => fed_get_input_details( array(
					'input_meta' => 'color[fed_upl_color_pbg_color]',
					'user_value' => isset( $fed_admin_options['color']['fed_upl_color_pbg_color'] ) ? $fed_admin_options['color']['fed_upl_color_pbg_color'] : '#f3f3f3',
					'input_type' => 'color'
				) ),
				'help_message' => fed_show_help_message( array(
					'content' => __( 'Default Widget Background Color #f3f3f3' ),
					'frontend-dashboard-templates'
				) )
			);

			return $array;
		}

		public function fedt_admin_settings_upl_color( $fed_admin_settings_upl, $request ) {
			$fed_admin_settings_upl['color']['fed_upl_color_bbg_color'] = isset( $request['color']['fed_upl_color_bbg_color'] ) ? sanitize_text_field( $request['color']['fed_upl_color_bbg_color'] ) : '#033333';

			$fed_admin_settings_upl['color']['fed_upl_color_cbg_color'] = isset( $request['color']['fed_upl_color_cbg_color'] ) ? sanitize_text_field( $request['color']['fed_upl_color_cbg_color'] ) : '#f3f3f3';

			$fed_admin_settings_upl['color']['fed_upl_color_wbg_color'] = isset( $request['color']['fed_upl_color_wbg_color'] ) ? sanitize_text_field( $request['color']['fed_upl_color_wbg_color'] ) : '#f3f3f3';

			$fed_admin_settings_upl['color']['fed_upl_color_pbg_color'] = isset( $request['color']['fed_upl_color_pbg_color'] ) ? sanitize_text_field( $request['color']['fed_upl_color_pbg_color'] ) : '#f3f3f3';

			return $fed_admin_settings_upl;
		}

		public function fedt_remove_admin_bar() {
			$fed_admin_options = get_option( 'fed_admin_settings_upl' );
			if ( isset( $fed_admin_options['settings']['fed_upl_hide_admin_bar'] ) && $fed_admin_options['settings']['fed_upl_hide_admin_bar'] === 'yes' ) {
				return false;
			}

			return true;
		}

		public function add_template_part( $template ) {
			$is_template_active = get_option( 'fed_admin_settings_upl' );
			if ( $is_template_active['settings']['fed_upl_template_model'] === 'default' ) {
				$template[295] = FED_TEMPLATES_PLUGIN_DIR . '/templates';
			}
			if ( $is_template_active['settings']['fed_upl_template_model'] === 'template1' ) {
				$template[5] = FED_TEMPLATES_PLUGIN_DIR . '/templates';
			}

			return $template;
		}

		public function fedt_plugin_versions( $version ) {
			return array_merge( $version, array( 'dashboard_template' => __( 'Dashboard Template (' . FED_TEMPLATES_PLUGIN_VERSION . ')', 'frontend-dashboard-templates' ) ) );
		}

		public function fedt_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'FED Right Sidebar', 'frontend-dashboard-templates' ),
				'id'            => 'fed_dashboard_right_sidebar',
				'description'   => __( 'The Frontend Dashboard Right Sidebar on Custom Template', 'frontend-dashboard-templates' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}

		public function fedt_add_inline_css_at_head() {
			$fed_colors = get_option( 'fed_admin_setting_upl_color' );
			if ( $fed_colors !== false ) {
				$bbg_color      = isset( $fed_colors['color']['fed_upl_color_bbg_color'] ) ? $fed_colors['color']['fed_upl_color_bbg_color'] : 'transparent';
				$wbg_font_color = isset( $fed_colors['color']['fed_upl_color_wbg_color'] ) ? $fed_colors['color']['fed_upl_color_wbg_color'] : '#f3f3f3';
				$cbg_color      = isset( $fed_colors['color']['fed_upl_color_cbg_color'] ) ? $fed_colors['color']['fed_upl_color_cbg_color'] : '#f3f3f3';
				$pbg_color      = isset( $fed_colors['color']['fed_upl_color_pbg_color'] ) ? $fed_colors['color']['fed_upl_color_pbg_color'] : '#f3f3f3';
				$sbg_color      = isset( $fed_colors['color']['fed_upl_color_sbg_color'] ) ? $fed_colors['color']['fed_upl_color_sbg_color'] : '#033333';
				$sfont_color      = isset( $fed_colors['color']['fed_upl_color_sbg_font_color'] ) ? $fed_colors['color']['fed_upl_color_sbg_font_color'] : '#FFFFFF';
				$prim_bg_color      = isset( $fed_colors['color']['fed_upl_color_pbg_color'] ) ? $fed_colors['color']['fed_upl_color_pbg_color'] : '#0AAAAA';

				?>
				<style>
					body {
						 background-color: <?php echo $bbg_color?> !important;
					 }

					.fed_dashboard_items {
						background-color: transparent !important;
					}

					.fed_ads {
						background-color: <?php echo $wbg_font_color ?> !important;
					}
					.bc_fed .fed_menu_slug a {
						background-color: <?php echo $sbg_color ?> !important;
						color: <?php echo $sfont_color ?>;
						margin-right: 10px;
					}
					.bc_fed .fed_menu_slug.active a {
						background-color: <?php echo $prim_bg_color ?> !important;
					}
					.bc_fed .panel-body {
						background-color: <?php echo $pbg_color ?> !important;
					}
				</style>
				<?php
			}
		}

		public function fedt_change_author_frontend_page( ) {
			return FED_TEMPLATES_PLUGIN_DIR;
		}

	}

	new FEDT_Hooks();
}