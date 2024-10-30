<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Circular Progress Bar
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_borderless_wpbakery_circular_progress_bar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'percentage' => '50',
			'bar_thickness' => '16',
			'track_thickness' => '16',
			'corner' => 'butt',
			'colors' => '',
			'title_color' => '',
			'ip_color' => '',
			'bar_color' => '',
			'track_color' => '',
			'style' => 'percentage',
			'icon' => '',
			//Static
			'el_id' => '',
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
		), $atts ) );
		$output = '';
		$borderless_global_color = 'borderless-global-color'; //General Color

		// Assets.
		wp_enqueue_style(
			'borderless-wpbakery-style',
			BORDERLESS__STYLES . 'wpbakery.min.css', 
			false, 
			BORDERLESS__VERSION
		);
		wp_enqueue_script(
			'borderless-wpbakery-appear-script',
			BORDERLESS__LIB . 'appear.js', array('jquery'), 
			'1.0.0', 
			true 
		);
		wp_enqueue_script(
			'borderless-wpbakery-progressbar-script',
			BORDERLESS__LIB . 'progressbar.js', array('jquery'), 
			'1.1.0', 
			true 
		);
		wp_enqueue_script(
			'borderless-wpbakery-script',
			BORDERLESS__SCRIPTS . 'borderless-wpbakery.min.js', array('jquery'), 
			BORDERLESS__VERSION, 
			true 
		);


		// Retrieve data from the database.
		$options = get_option( 'borderless' );


		// Set default value.
		$borderless_primary_color = isset( $options['primary_color'] ) ? $options['primary_color'] : '#3379fc'; //Primary Color
		$borderless_secondary_color = isset( $options['secondary_color'] ) ? $options['secondary_color'] : '#3379fc'; //Secondary Color
		$borderless_text_color = isset( $options['text_color'] ) ? $options['text_color'] : ''; //Text Color
		$borderless_accent_color = isset( $options['accent_color'] ) ? $options['accent_color'] : '#3379fc'; //Accent Color
		

		// Default Extra Class, CSS and CSS animation
		$css = isset( $atts['css'] ) ? $atts['css'] : '';
		$el_id = isset( $atts['el_id'] ) ? 'id="' . esc_attr( $el_id ) . '"' : '';
		$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';
		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$css_animation_style = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}
		$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
		

		// Set custom values	
		$title_color = $title_color ? 'style=color:'.$title_color.'' : 'style=color:'.$borderless_primary_color.'';
		$percentage_color = $ip_color;
		$ip_color = $ip_color ? 'style=color:'.$ip_color.'' : 'style=color:'.$borderless_primary_color.'';
		$bar_color = $bar_color ? $bar_color : $borderless_primary_color;
		$track_color = $track_color ? $track_color : '#f9f9f9';


		// Output
		if ($style=="icon") { $icon = '<i '.$ip_color.' class="borderless-wpbakery-circular-progress-bar-icon '.$icon.'""></i>'; } else { $icon = ""; }
		$output .= '<div '.$el_id.' class="borderless-wpbakery-circular-progress-bar '.$css_class.'">';
		$output .= '<div class="borderless-wpbakery-circular-progress-bar-inner">';
		$output .= '<div class="borderless-wpbakery-circular-progress-bar-params '.$corner.' '.$style.'" percentage="'.$percentage.'" bar_color="'.$bar_color.'" track_color="'.$track_color.'" percentage_color="'.$percentage_color.'" bar_thickness="'.$bar_thickness.'" track_thickness="'.$track_thickness.'"></div>';
		$output .= $icon;
		$output .= '<span '.$title_color.' class="borderless-wpbakery-circular-progress-bar-title">'.$title.'</span>';
		$output .= '</div></div>';
		
		return $output;
	}
}

return array(
	'name' => __( 'Circular Progress Bar', 'borderless' ),
	'base' => 'borderless_wpbakery_circular_progress_bar',
	'icon' => plugins_url('../images/circular-progress-bar.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Borderless', 'borderless' ),
	'description' => __( 'Animated progress bar', 'borderless' ),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'borderless' ),
			'param_name' => 'title',
			'description' => __( 'Enter the Progress Bar title here.', 'borderless' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'borderless' ),
			'param_name' => 'style',
			'value' => array(
				__( 'Percentage', 'borderless' ) => 'percentage',
				__( 'Icon', 'borderless' ) => 'icon',
			),
			'description' => __( 'Choose a style.', 'borderless' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Progress in %', 'borderless' ),
			'param_name' => 'percentage',
			'description' => __( 'Enter a number between 0 and 100', 'borderless' ),
		),
		
		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'borderless' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'borderless' ),
			'dependency' => array(
				'element' => 'style',
				'value' => 'icon'
			),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Bar Thickness', 'borderless' ),
			'param_name' => 'bar_thickness',
			'description' => __( 'Enter a value for height. Ex: 16.', 'borderless' ),
		),

		array(
			'type' => 'textfield',
			'heading' => __( 'Track Thickness', 'borderless' ),
			'param_name' => 'track_thickness',
			'description' => __( 'Enter a value for height. Ex: 16.', 'borderless' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Corner Style', 'borderless' ),
			'description' => __( 'Select style.', 'borderless' ),
			'param_name' => 'corner',
			'value' => array(
				__( 'Square', 'borderless' ) => 'butt',
				__( 'Round', 'borderless' ) => 'round',
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Colors', 'borderless' ),
			'param_name' => 'colors',
			'value' => array(
				__( 'Preset Color', 'borderless' ) => '',
				__( 'Custom Color', 'borderless' ) => 'custom',
			),
			'description' => __( 'Choose a color for your progress bar here.', 'borderless' ),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'borderless' ),
			'param_name' => 'title_color',
			'description' => __( 'Select custom color for the title.', 'borderless' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Percentage and Icon Color', 'borderless' ),
			'param_name' => 'ip_color',
			'description' => __( 'Select custom color for the percentage or icon.', 'borderless' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Bar Color', 'borderless' ),
			'param_name' => 'bar_color',
			'description' => __( 'Select custom color for the bar.', 'borderless' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Track Color', 'borderless' ),
			'param_name' => 'track_color',
			'description' => __( 'Select custom color for the track.', 'borderless' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		// Animation
		vc_map_add_css_animation(),

		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'borderless' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'borderless' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'borderless' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'borderless' ),
		),
		
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'borderless' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'borderless' ),
		),
	),
);
