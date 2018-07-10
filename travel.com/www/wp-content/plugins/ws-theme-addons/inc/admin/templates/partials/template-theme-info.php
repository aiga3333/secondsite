<?php
/**
 * Thema info tab contents.
 *
 * @package WS Theme Addons
 */

$theme = wp_get_theme( get_template() );
?>
<div class="wrap about-wrap">
		<h1><?php echo esc_html( $theme->display( 'Name' ) ); ?></h1>
		<div class="two-col">

			<div class="col about-text">
				<?php
					$description_raw = $theme->display( 'Description' );
					$main_description = explode( 'Official', $description_raw );
					?>
				<?php echo wp_kses_post( $main_description[0] ); ?>
				<p><?php esc_html_e( 'Version', 'ws-theme-addons' ); ?>:&nbsp;<?php echo esc_html( $theme->display( 'Version' ) ); ?></p>
			</div><!-- .col -->

			<div class="col about-img">
				<a href="<?php echo esc_url( $theme->display( 'ThemeURI' ) ); ?>" target="_blank"><img src="<?php echo trailingslashit( get_template_directory_uri() ); ?>screenshot.png" alt="<?php echo esc_attr( $theme->display( 'Name' ) ); ?>" /></a>
			</div><!-- .col -->

		</div><!-- .two-col -->
		<div class="two-col">

			<div class="col">

				<h3><i class="dashicons dashicons-admin-customizer"></i><?php esc_html_e( 'Theme Options', 'ws-theme-addons' ); ?></h3>

				<p>
					<?php esc_html_e( 'Customizer API for theme options which will help you preview your changes live and fast.', 'ws-theme-addons' ); ?>
				</p>

				<p>
					<a class="button button-primary" href="<?php echo esc_url( wp_customize_url() ); ?>" ><?php esc_html_e( 'Customize', 'ws-theme-addons' ); ?></a>
				</p>

			</div><!-- .col -->

			<?php  if( $theme->Author == '<a href="http://wensolutions.com">WEN Solutions</a>' ) : ?>

			<div class="col">

				<h3><i class="dashicons dashicons-archive"></i><?php esc_html_e( 'Import Demo Contents', 'ws-theme-addons' ); ?></h3>
				<p>
					<?php esc_html_e( 'Import demo contents data for the theme', 'ws-theme-addons' ); ?>
				</p>
				<p>
					<button class="ws-theme-demo-import-submit button button-primary" ><?php esc_html_e( 'Import Demo', 'ws-theme-addons' ); ?></button>
					<div id="response"></div>
					
				</p>

				<div id="bod" style="display:none" class="cogs">
					<div class="cog--left"></div>
					<div class="cog--right"></div>
					<div class="cog--center"></div>
				</div>
				<div id="bod-text" style="display:none" class="cssload-loader"><?php echo esc_html( 'Importing...','ws-theme-addons' ); ?></div>

			</div><!-- .col -->

		<?php endif; ?>

		</div><!-- .four-col -->


	</div><!-- .wrap -->
