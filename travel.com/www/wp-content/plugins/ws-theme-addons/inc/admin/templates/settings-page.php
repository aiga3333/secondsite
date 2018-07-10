<?php
/**
 * Admin Settings page for the Plugin.
 *
 * @package WS Theme Addons
 */

$ws_theme_addons_saved_settings = get_option( 'ws_theme_addons_admin_settings' );
$theme = wp_get_theme( get_template() );
?>
<div class="ws-theme-addons-settings-tab">
	<?php if ( isset( $_GET['success'] ) && 'true' == $_GET['success'] ) : ?>
		<div id="ws-theme-addons-settings_updated"> 
			<p class="settings-success-msg" >
				<strong><?php echo esc_html__( 'Settings saved.', 'ws-theme-addons' ); ?></strong>
			</p>
			<button type="button" class="ws-close-save-settings-notice">
				 <span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'ws-theme-addons' ); ?></span>
			</button>
		</div>
	<?php endif; ?>
	<div id="ws-theme-addons-tabs">
		<ul>
			<li>
				<a href="#ws-tabs-theme-info"><?php esc_html_e( 'Theme Info', 'ws-theme-addons' ); ?></a>
			</li>
			<li>
				<a href="#ws-tabs-features-addons"><?php esc_html_e( 'Features & Addons', 'ws-theme-addons' ); ?></a>
			</li>
		</ul>
	
		<form method="post" id="ws-theme-addons-settings-form-id" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ws-theme-addons-settings-form">
		
			<input type="hidden" name="action" value="ws_theme_addons_save_settings"/>
				
				<?php wp_nonce_field( 'ws-theme-addons-settings-nonce', 'ws_theme_addons_settings_nonce_field' ); ?>
					<div id="ws-tabs-theme-info">
						<?php include sprintf( '%s/inc/admin/templates/partials/template-theme-info.php', WS_THEME_ADDONS_ABSPATH ); ?>
					</div>

					<div id="ws-tabs-features-addons">
						<?php include sprintf( '%s/inc/admin/templates/partials/template-features-addons.php', WS_THEME_ADDONS_ABSPATH ); ?>
					</div>
		</form>
	</div>
</div>
