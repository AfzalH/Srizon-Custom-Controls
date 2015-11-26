<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
if ( class_exists( 'Srizon_Control_Slider' ) ) {
	return null;
}

class Srizon_Control_Slider extends WP_Customize_Control {

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$defaults = [
//			'step' => 1,
			'min' => 1,
			'max' => 100,
		];
		$this->merged_options = $options + $defaults;
		parent::__construct( $manager, $id, $args );
	}

	public function enqueue() {
//		noUiSlider
		wp_enqueue_style( 'nouislider', '//cdnjs.cloudflare.com/ajax/libs/noUiSlider/8.1.0/nouislider.min.css' );
		wp_enqueue_script( 'nouislider', '//cdnjs.cloudflare.com/ajax/libs/noUiSlider/8.1.0/nouislider.min.js', array( 'jquery' ) );
	}

	public function render_content() {
		$slider_input_id = $this->id;
		$slider_ui_id = $this->id.'-ui';
		?>
		<label> <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span> <span
				class="description customize-control-description"><?php echo $this->description; ?></span> <input
				type="hidden" <?php $this->link();?> id="<?php echo $slider_input_id;?>" value="<?php echo $this->value();?>">
		</label>
		<div id="<?php echo $slider_ui_id;?>" style="margin-top: 40px;"></div>
		<script>
			var handlesSlider<?php echo $this->id;?> = document.getElementById('<?php echo $slider_ui_id;?>');

			noUiSlider.create(handlesSlider<?php echo $this->id;?>, {
				start: [<?php echo $this->value();?>],
				tooltips: true,
				<?php if (isset($this->merged_options['step'])){
				echo 'step: '.$this->merged_options['step'].',';
				}?>
				range: {
					'min': [<?php echo $this->merged_options['min']?>],
					'max': [<?php echo $this->merged_options['max']?>]
				},
				format: {
					to: function ( value ) {
						return value + '';
					},
					from: function ( value ) {
						return value.replace('px', '');
					}
				}
			});

			var inputFormat<?php echo $this->id;?> = document.getElementById('<?php echo $slider_input_id;?>');
			handlesSlider<?php echo $this->id;?>.noUiSlider.on('update', function( values, handle ) {
				inputFormat<?php echo $this->id;?>.value = values[handle];
				jQuery(inputFormat<?php echo $this->id;?>).trigger('change');
			});
		</script>
		<?php
	}
}


