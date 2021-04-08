<h2>Beecomm API Settings Page</h2>
<form action="options.php" method="post">
	<?php
	settings_fields( 'beecomm_api_options' );
	do_settings_sections( 'beecomm_api' ); ?>
	<br>
	<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
</form>