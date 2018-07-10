<?php
/**
 * Admin Features and Addons.
 *
 * @package WS Theme Addons
 */

$instagram_enable = isset( $ws_theme_addons_saved_settings['instagram_enable'] )  ? $ws_theme_addons_saved_settings['instagram_enable'] : 'no';

?>

<div class="wrap">

<div class="col ws-centered">

	<div class="ws-settings-section">

		<h1 class="ws-theme-tab-title" ><?php echo esc_html( 'Widgets and Layout Options', 'ws-theme-addons' ); ?></h1>

		<div class="ws-theme-addon-setting clearfix">

			<div class="ws-theme-addons-setting-label-wrap">
				<label class="ws-theme-addon-setting-label" for="checkbox-enable-insta"><?php esc_html_e( 'Enable Instagram Widget', 'ws-theme-addons' ); ?></label><br>
				<span class="info-block" ><i><?php echo esc_html( 'A new Instagram Feed Widget will be available in widgets page that can be placed in widgets areas in your theme.', 'ws-theme-addons' ); ?></i></span>
			</div>
			
			<label for="checkbox-enable-insta" class="switch">
				<input id="checkbox-enable-insta" name="ws_theme_addons_settings[instagram_enable]" type="checkbox" value="1" <?php checked( $instagram_enable , 'yes' ); ?> >
				<span class="slider round"></span>
			</label>
		
		</div>

	</div>

	<hr>
	<div class="ws-theme-addons-save-wrap">
		<div>
			<input type="submit" name="ws_theme_addons_save_settings_submit" value="<?php esc_html_e( 'Save Changes', 'ws-theme-addons' ); ?>" class="button button-primary"/>
		</div>
	</div>

</div><!-- .two-col -->
</div>
