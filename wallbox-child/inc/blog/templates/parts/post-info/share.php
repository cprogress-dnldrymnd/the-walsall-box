<?php if ( class_exists( 'EsmeeCore_Social_Share_Shortcode' ) ) { ?>
	<?php
	$params              = array();
	$params['layout']    = 'text';
	$params['title']     = 'Share: ';
	$params['icon_font'] = 'elegant-icons';
	
	echo EsmeeCore_Social_Share_Shortcode::call_shortcode( $params ); ?>
<?php } ?>
