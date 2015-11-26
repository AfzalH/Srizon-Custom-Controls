<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
if ( class_exists( 'Srizon_Control_Google_Font' ) ) {
	return null;
}

/**
 * A class to create a dropdown for all google fonts
 */
class Srizon_Control_Google_Font extends WP_Customize_Control {
	private $fonts = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->fonts = $this->get_fonts();
		parent::__construct( $manager, $id, $args );
	}

	public function enqueue() {
//		Select 2 script for better dropdown
		wp_enqueue_style( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css' );
		wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js', array( 'jquery' ) );
	}

	/**
	 * Render the content of the category dropdown
	 *
	 * @return null
	 */
	public function render_content() {
		if ( ! empty( $this->fonts ) ) {
			?>
			<label> <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span> <span
					class="description customize-control-description"><?php echo $this->description; ?></span> <span
					class="total-fonts description customize-control-description"><?php _e( 'Total Fonts: ' );
					echo count( $this->fonts ); ?></span> <select class="select-two" <?php $this->link(); ?>>
					<?php
					foreach ( $this->fonts as $v ) {
						printf( '<option value="%s" %s>%s</option>', $v->family, selected( $this->value(), $v->family, false ), $v->family );
					}
					?>
				</select> </label>

			<script type="text/javascript">
				jQuery('.select-two').select2({
					width: '100%'
				});
			</script>
			<style>
				.wp-full-overlay {
					z-index: 500 !important; /* Lower the z-index of customizer overlay so that select2 is visible*/
				}
			</style>
			<?php
		}
	}

	/**
	 * Get the google fonts from the API or in the cache
	 *
	 * @param  $amount
	 *
	 * @return array
	 */
	public function get_fonts( $amount = 'all' ) {

		$fontFile = dirname( __FILE__ ) . '/cache/google-web-fonts.txt';

		//Total time the file will be cached in seconds, set to a month
		$cachetime = 86400 * 30;

		if ( file_exists( $fontFile ) && $cachetime > ( time() - filemtime( $fontFile ) ) ) {
			$content = json_decode( file_get_contents( $fontFile ) );
		} else {

			$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyAZJCmEe0GaEwdKv2EKYjtMdBSUDvYgIbc&fields=items/family';

			$fontContent = wp_remote_get( $googleApi, array( 'sslverify' => false ) );
			if ( ! is_wp_error( $fontContent ) and $fontContent['response']['code'] == 200 ) {
				if ( ! is_dir( dirname( __FILE__ ) . '/cache' ) ) {
					mkdir( dirname( __FILE__ ) . '/cache' );
				}
				file_put_contents( $fontFile, $fontContent['body'] );
				$content = json_decode( $fontContent['body'] );
			} else {
				if ( file_exists( $fontFile ) ) {
					$content = json_decode( file_get_contents( $fontFile ) );
					file_put_contents( $fontFile, file_get_contents( $fontFile ) );

				} else {
					return array();
				}
			}


		}

		if ( $amount == 'all' ) {
			return $content->items;
		} else {
			return array_slice( $content->items, 0, $amount );
		}
	}
}

?>