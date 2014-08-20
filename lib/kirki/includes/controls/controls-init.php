<?php

/**
 * Build the controls
 */
function kirki_customizer_controls( $wp_customize ) {

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

			if ( 'background' == $control['type'] ) {

				$control_before = ( 'theme_mod' == $option_mode ) ? $control['setting'] : $option_name . '[' . $control['setting'];
				$control_after  = ( 'theme_mod' == $option_mode ) ? null : ']';

				$wp_customize->add_setting( $control_before . '_color', array(
					'default'    => $control['default']['color'],
					'type'       => $option_mode,
					// 'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control_before . '_image' . $control_after, array(
					'default'    => $control['default']['image'],
					'type'       => $option_mode,
					// 'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control_before . '_repeat' . $control_after, array(
					'default'    => $control['default']['repeat'],
					'type'       => $option_mode,
					// 'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control_before . '_size' . $control_after, array(
					'default'    => $control['default']['size'],
					'type'       => $option_mode,
					// 'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control_before . '_attach' . $control_after, array(
					'default'    => $control['default']['attach'],
					'type'       => $option_mode,
					// 'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control_before . '_position' . $control_after, array(
					'default'    => $control['default']['position'],
					'type'       => $option_mode,
					// 'transport'   => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				if ( false != $control['default']['opacity'] ) {

					$wp_customize->add_setting( $control_before . '_opacity' . $control_after, array(
						'default'    => $control['default']['opacity'],
						'type'       => $option_mode,
						// 'transport'  => 'postMessage',
						'capability' => 'edit_theme_options'
					) );

				}

			} else {

				$control_name = ( 'theme_mod' == $option_mode ) ? $control['setting'] : $option_name . '[' . $control['setting'] . ']';

				// Add settings
				$wp_customize->add_setting( $control_name, array(
					'default'    => isset( $control['default'] ) ? $control['default'] : '',
					'type'       => $option_mode,
					// 'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

			}

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Checkbox_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Background Controls
			} elseif ( 'background' == $control['type'] ) {

				$control_before = ( 'theme_mod' == $option_mode ) ? $control['setting'] : $option_name . '[' . $control['setting'];
				$control_after  = ( 'theme_mod' == $option_mode ) ? null : ']';

				$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control_before . '_color' . $control_after, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_before . '_color' . $control_after,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => __( 'Background Color', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control_before . '_image' . $control_after, array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control_before . '_image' . $control_after,
						'priority'    => $control['priority'] + 1,
						'description' => null,
						'subtitle'    => __( 'Background Image', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control_before . '_repeat' . $control_after, array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control_before . '_repeat' . $control_after,
						'priority'    => $control['priority'] + 2,
						'choices'     => array(
							'no-repeat' => __( 'No Repeat', 'kirki' ),
							'repeat'    => __( 'Repeat All', 'kirki' ),
							'repeat-x'  => __( 'Repeat Horizontally', 'kirki' ),
							'repeat-y'  => __( 'Repeat Vertically', 'kirki' ),
							'inherit'   => __( 'Inherit', 'kirki' )
						),
						'description' => null,
						'subtitle'    => __( 'Background Repeat', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control_before . '_size' . $control_after, array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control_before . '_size' . $control_after,
						'priority'    => $control['priority'] + 3,
						'choices'     => array(
							'inherit' => __( 'Inherit', 'kirki' ),
							'cover'   => __( 'Cover', 'kirki' ),
							'contain' => __( 'Contain', 'kirki' ),
						),
						'description' => null,
						'mode'        => 'buttonset',
						'subtitle'    => __( 'Background Size', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control_before . '_attach' . $control_after, array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control_before . '_attach' . $control_after,
						'priority'    => $control['priority'] + 4,
						'choices'     => array(
							'inherit' => __( 'Inherit', 'kirki' ),
							'fixed'   => __( 'Fixed', 'kirki' ),
							'scroll'  => __( 'Scroll', 'kirki' ),
						),
						'description' => null,
						'mode'        => 'buttonset',
						'subtitle'    => __( 'Background Attachment', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control_before . '_position' . $control_after, array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control_before . '_position' . $control_after,
						'priority'    => $control['priority'] + 5,
						'choices'     => array(
							'left-top'      => __( 'Left Top', 'kirki' ),
							'left-center'   => __( 'Left Center', 'kirki' ),
							'left-bottom'   => __( 'Left Bottom', 'kirki' ),
							'right-top'     => __( 'Right Top', 'kirki' ),
							'right-center'  => __( 'Right Center', 'kirki' ),
							'right-bottom'  => __( 'Right Bottom', 'kirki' ),
							'center-top'    => __( 'Center Top', 'kirki' ),
							'center-center' => __( 'Center Center', 'kirki' ),
							'center-bottom' => __( 'Center Bottom', 'kirki' ),
						),
						'description' => null,
						'subtitle'    => __( 'Background Position', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				if ( false != $control['default']['opacity'] ) {
					$wp_customize->add_control( new Kirki_Customize_Sliderui_Control( $wp_customize, $control_before . '_opacity' . $control_after, array(
							'label'       => null,
							'section'     => $control['section'],
							'settings'    => $control_before . '_opacity' . $control_after,
							'priority'    => $control['priority'] + 6,
							'choices'  => array(
								'min'  => 0,
								'max'  => 100,
								'step' => 1,
							),
							'description' => null,
							'subtitle'    => __( 'Background Opacity', 'kirki' ),
							'required'    => isset( $control['required'] ) ? $control['required'] : array(),
							'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
						) )
					);
				}

			// Color Controls
			} elseif ( 'color' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => isset( $control['priority'] ) ? $control['priority'] : '',
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Image Controls
			} elseif ( 'image' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Radio Controls
			} elseif ( 'radio' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'mode'        => isset( $control['mode'] ) ? $control['mode'] : 'radio', // Can be 'radio', 'image' or 'buttonset'.
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Select Controls
			} elseif ( 'select' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Slider Controls
			} elseif ( 'slider' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Sliderui_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Text Controls
			} elseif ( 'text' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Text_Control( $wp_customize, $control_name, array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Text Controls
			} elseif ( 'textarea' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Textarea_Control( $wp_customize, $control_name, array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Upload Controls
			} elseif ( 'upload' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Upload_Control( $wp_customize, $control_name, array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Number Controls
			} elseif ( 'number' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Number_Control( $wp_customize, $control_name, array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Multicheck Controls
			} elseif ( 'multicheck' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Multicheck_Control( $wp_customize, $control_name, array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Separator Controls
			} elseif ( 'group_title' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Group_Title_Control( $wp_customize, $control_name, array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control_name,
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);
			}
		}
	}
}
add_action( 'customize_register', 'kirki_customizer_controls', 99 );
