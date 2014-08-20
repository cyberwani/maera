<?php

/**
 * Apply custom backgrounds to our page.
 */
function kirki_background_css() {

	$controls = apply_filters( 'kirki/controls', array() );
	$config   = apply_filters( 'kirki/config', array() );

	if ( ! isset( $config['option_mode'] ) || empty( $config['option_mode'] ) || $config['option_mode'] == 'theme_mod' ) {

		$option_mode = 'theme_mod';

	} else {

		$option_mode = 'option';
		$option_name = ( ! isset( $config['option_name'] ) || ! empty( $config['option_name'] ) ) ? 'kirki' : $config['option_name'];

	}

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			if ( 'theme_mod' == $option_mode ) {

				$control_name =  $control['setting'];

			} else {

				$control_name = $option_name . '[' . $control['setting'] . ']';

			}

			if ( 'background' == $control['type'] && isset( $control_name ) ) {

				// Apply custom CSS if we've set the 'output'.
				if ( ! is_null( $control['output'] ) ) {

					$bg_color    = kirki_sanitize_hex( Kirki::get_option( $control_name . '_color', $control['default']['color'] ) );
					$bg_image    = Kirki::get_option( $control_name . '_image', $control['default']['image'] );
					$bg_repeat   = Kirki::get_option( $control_name . '_repeat', $control['default']['repeat'] );
					$bg_size     = Kirki::get_option( $control_name . '_size', $control['default']['size'] );
					$bg_attach   = Kirki::get_option( $control_name . '_attach', $control['default']['attach'] );
					$bg_position = Kirki::get_option( $control_name . '_position', $control['default']['position'] );
					$bg_opacity  = Kirki::get_option( $control_name . '_opacity', $control['default']['opacity'] );

					if ( false != $control['default']['opacity'] ) {

						$bg_position = Kirki::get_option( $control_name . '_opacity', $control['default']['opacity'] );

						// If we're using an opacity other than 100, then convert the color to RGBA.
						if ( 100 != $bg_opacity ) {
							$bg_color = kirki_get_rgba( $bg_color, $bg_opacity );
						}

					}

					// HTML Background
					$styles = $control['output'] . '{';

						$styles .= 'background-color:' . $bg_color . ';';

						if ( '' != $bg_image ) {
							$styles .= 'background-image: url("' . $bg_image . '");';
							$styles .= 'background-repeat: ' . $bg_repeat . ';';
							$styles .= 'background-size: ' . $bg_size . ';';
							$styles .= 'background-attachment: ' . $bg_attach . ';';
							$styles .= 'background-position: ' . str_replace( '-', ' ', $bg_position ) . ';';
						}

					$styles .= '}';
				}

				wp_add_inline_style( $config['stylesheet_id'], $styles );

			}

		}
	}

}
add_action( 'wp_enqueue_scripts', 'kirki_background_css', 150 );
