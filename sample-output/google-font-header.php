<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php
	$body_font = urlencode(get_theme_mod('srizon_body_font'));
	echo <<<END
<link href='https://fonts.googleapis.com/css?family={$body_font}' rel='stylesheet' type='text/css'>
END;

	?>
	<?php wp_head(); ?>
	<style>
		body{
			font-family: "<?php echo get_theme_mod('srizon_body_font')?>";
		}
	</style>
</head>