<?php

/**
 * Allow shortcodes in widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Fix Shortcodes
 */
if( !function_exists('rescue_fix_shortcodes') ) {
	function rescue_fix_shortcodes($content){
		$array = array (
			'<p>['		=> '[',
			']</p>'		=> ']',
			']<br />'	=> ']'
		);

		return strtr($content, $array);
	}
	add_filter('the_content', 'rescue_fix_shortcodes');
}

/**
 * Clear Floats
 */
if( !function_exists('rescue_clear_floats_shortcode') ) {
	function rescue_clear_floats_shortcode() {
	   return '<div class="rescue-clear-floats"></div>';
	}
	add_shortcode( 'rescue_clear_floats', 'rescue_clear_floats_shortcode' );
}

/**
 * Spacing
 */
if( !function_exists('rescue_spacing_shortcode') ) {
	function rescue_spacing_shortcode( $atts ) {
		$atts = shortcode_atts( array(
				'size'	=> '30px',
				'class'	=> '',
		  		),
		  		$atts );
		$size = sanitize_html_class( $atts['size'] );
		$class = sanitize_html_class( $atts['class'] );
		 
	 return '<hr class="rescue-spacing '. esc_attr( $class ) .'" style="height: '. esc_attr( $size ) .'" />';
	}
	add_shortcode( 'rescue_spacing', 'rescue_spacing_shortcode' );
}

/**
 * Highlights
 */
if ( !function_exists( 'rescue_highlight_shortcode' ) ) {
	function rescue_highlight_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'color'			=> 'yellow',
				'class'			=> '',
				'visibility'	=> 'all',
		  		
				),$atts );
		  
		  $color = sanitize_html_class( $atts['color'] );
		  $visibility = sanitize_html_class( $atts['visibility'] );
		  $class = sanitize_html_class( $atts['class'] );
		  $content = wp_kses_post( $content );
		  
		  return '<span class="rescue-highlight rescue-highlight-'. esc_attr( $color ) .' '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'">' . do_shortcode( $content ) . '</span>';

	}
	add_shortcode('rescue_highlight', 'rescue_highlight_shortcode');
}

/**
 * Buttons
 */
if( !function_exists('rescue_button_shortcode') ) {
	function rescue_button_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'color'				=> '',
				'colorhex'			=> '',
				'colorhexhover'		=> '',
				'url'				=> 'https://rescuethemes.com',
				'title'				=> 'Visit Site',
				'target'			=> 'self',
				'rel'				=> '',
				'border_radius'		=> '',
				'class'				=> '',
				'icon_left'			=> '',
				'icon_right'		=> '',
				'visibility'		=> 'all',
	
			 	// New icon
				'icon_enabled'  	=> '',
				'icon_type'  		=> '',
				'icon_size' 		=> '',
				'icon_rotate' 		=> '',
				'icon_flip' 		=> '',
				'icon_animated' 	=> '',
				'icon_color' 		=> '',
				'icon_margin'		=> '',
				
				), $atts );
		
		$rel = ( $rel ) ? 'rel="'.$rel.'"' : NULL;

		$button = NULL;
		
		$color = sanitize_html_class( $atts['color'] );
		$colorhex = sanitize_html_class( $atts['colorhex'] );
		$colorhexhover = sanitize_html_class( $atts['colorhexhover'] );
		$url = sanitize_url( $atts['url'] );
		$title = sanitize_html_class( $atts['class'] );
		$target = sanitize_html_class( $atts['target'] );
		$rel = sanitize_html_class( $atts['rel'] );
		$border_radius = sanitize_html_class( $atts['border_radius'] );
		$class = sanitize_html_class( $atts['class'] );
		$icon_left = sanitize_html_class( $atts['icon_left'] );
		$icon_right = sanitize_html_class( $atts['icon_right'] );
		$visibility = sanitize_html_class( $atts['visibility'] );
		$icon_enabled = boolval( $atts['icon_enabled'] );
		$icon_type = sanitize_html_class( $atts['icon_type'] );
		$icon_size = sanitize_html_class( $atts['icon_size'] );
		$icon_rotate = sanitize_html_class( $atts['icon_rotate'] );
		$icon_flip = sanitize_html_class( $atts['icon_flip'] );
		$icon_animated = sanitize_html_class( $atts['icon_animated'] );
		$icon_color = sanitize_text_field( $atts['icon_color'] );  
		$icon_margin = sanitize_html_class( $atts['icon_margin'] );
		  
		$content = wp_kses_post( $content );
		
		$button .= '<a style="background: ' . esc_attr( $colorhex ) . ';border-radius: ' . esc_attr( $border_radius ) . ' " href="' . esc_url( $url ) . '" class="rescue-button ' . esc_attr( $color ) . ' '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'" target="_'. esc_attr(  $target ).'" title="'. $title .'" '. esc_attr( $rel ) .'>';
			$button .= '<span class="rescue-button-inner">';
				if ( $icon_enabled == true ) $button .=  RescueButtonIcon( $atts ); 
				if ( $icon_left ) $button .= '<span class="rescue-button-icon-left icon-'. esc_attr( $icon_left ) .'"></span>';
				$button .= $content;
				if ( $icon_right ) $button .= '<span class="rescue-button-icon-right icon-'. esc_attr( $icon_right ) .'"></span>';
			$button .= '</span>';

		$button .= '</a>';

		return $button;
	}
	add_shortcode('rescue_button', 'rescue_button_shortcode');
}

/**
 * Boxes
 */
if( !function_exists('rescue_box_shortcode') ) {
	function rescue_box_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'color'				=> 'gray',
				'float'				=> 'center',
				'text_align'		=> 'left',
				'width'				=> '100%',
				'margin_top'		=> '',
				'margin_bottom'		=> '',
				'class'				=> '',
				'visibility'		=> 'all',
		    	), $atts );
		
		$style_attr = '';
		if( $margin_bottom ) {
			$style_attr .= 'margin-bottom: '. $margin_bottom .';';
		}
		if ( $margin_top ) {
			$style_attr .= 'margin-top: '. $margin_top .';';
		}
		
		$color = sanitize_html_class( $atts['color'] );
		$float = sanitize_html_class( $atts['float'] );
		$text_align = sanitize_html_class( $atts['text_align'] );
		$width = sanitize_html_class( $atts['width'] );  
		$margin_top = sanitize_html_class( $atts['margin_top'] );
		$margin_bottom = sanitize_html_class( $atts['margin_bottom'] );    
		
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_html_class( $atts['visibility'] );
		  
		$content = wp_kses_post( $content );

	    $alert_content = '';
	    $alert_content .= '<div class="rescue-box ' . esc_attr( $color ) . ' '. esc_attr( $float ).' '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'" style="text-align:'. $text_align .'; width:'. $width .';'. $style_attr .'">';
	    $alert_content .= ' '. do_shortcode($content) .'</div>';
	    return $alert_content;
	}
	add_shortcode('rescue_box', 'rescue_box_shortcode');
}

/**
 * Columns
 */
if( !function_exists('rescue_column_shortcode') ) {
	function rescue_column_shortcode( $atts, $content = null ){
		$atts = shortcode_atts( array(
				'size'			=> 'one-third',
				'position'		=>'first',
				'class'			=> '',
				'visibility'	=> 'all',
		  		), $atts );
		
		$size = sanitize_html_class( $atts['size'] );
	  	$position = sanitize_html_class( $atts['position'] );  
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_html_class( $atts['visibility'] );

  		$content = wp_kses_post( $content );
		  
		return '<div class="rescue-column rescue-' . esc_attr( $size ) . ' rescue-column-'. esc_attr( $position ) .' '. esc_attr( $class) .' rescue-'. esc_attr( $visibility ) .'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('rescue_column', 'rescue_column_shortcode');
}

/**
 * Toggle
 */
if( !function_exists('rescue_toggle_shortcode') ) {
	function rescue_toggle_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'title'			=> 'Toggle Title',
				'class'			=> '',
				'visibility'	=> 'all',
				), $atts );
				
		$title = sanitize_text_field( $atts['title'] );
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_html_class( $atts['visibility'] );
				
		wp_enqueue_script('rescue_toggle');
		
		$content = wp_kses_post( $content );

		return '<div class="rescue-toggle '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'"><h3 class="rescue-toggle-trigger">'. $title .'</h3><div class="rescue-toggle-container">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('rescue_toggle', 'rescue_toggle_shortcode');
}

/**
 * Tab Group
 */
if (!function_exists('rescue_tabgroup_shortcode')) {
	function rescue_tabgroup_shortcode( $atts, $content = null ) {
		
		$content = wp_kses_post( $content );
		
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('rescue_tabs');

		// Display Tabs

		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		
		
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="rescue-tab-'. rand(1, 100) .'" class="rescue-tabs">';
			$output .= '<ul class="ui-tabs-nav rescue-clearfix">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#rescue-tab-'. sanitize_title( $tab[0] ) .'">' . wp_kses_post( $tab[0] ) . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'rescue_tabgroup', 'rescue_tabgroup_shortcode' );
}
if (!function_exists('rescue_tab_shortcode')) {
	function rescue_tab_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'title'			=> 'Tab',
				'class'			=> '',
				'visibility'	=> 'all',
				), $atts );
		
		$title = wp_kses_post( $atts['title'] );
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_html_class( $atts['visibility'] );
		
		$content = wp_kses_post( $content );
		
	    return '<div id="rescue-tab-'. sanitize_title( $title ) .'" class="tab-content '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'"><p>'. do_shortcode( $content ) .'</p></div>';
	}
	add_shortcode( 'rescue_tab', 'rescue_tab_shortcode' );
}

/**
 * Donation Tab Group
 */
if (!function_exists('rescue_donation_tabgroup_shortcode')) {
	function rescue_donation_tabgroup_shortcode( $atts, $content = null ) {

		$content = wp_kses_post( $content );
		
		$atts = shortcode_atts( array(
				'group_title' => '',
				), $atts );
				
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('rescue_donation_tabs');
		
		$group_title = sanitize_text_field( $atts['group_title'] );

		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="rescue-tab-'. rand(1, 100) .'" class="rescue-donation-tabs tabs-bottom">';
			$output .= '<ul class="ui-tabs-nav rescue-clearfix">';
			foreach( $tab_titles as $tab ){

				$output .= '<li><a href="#rescue-tab-'. sanitize_title( $tab[0] ) .'"><span>' . wp_kses_post( $tab[0] ) . '</span></a></li>';
			}
		    $output .= '</ul>';
		    $output .= '<div class="rescue_donation_header"> '. $group_title .' </div>';
		    $output .= do_shortcode( $content );
		    $output .= '</div><!-- .rescue-donation-tabs .tabs-bottom -->';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'rescue_donation_tabgroup', 'rescue_donation_tabgroup_shortcode' );
}
if (!function_exists('rescue_donation_tab_shortcode')) {
	function rescue_donation_tab_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'title'			=> 'Tab',
				'class'			=> '',
				'visibility'	=> 'all',
				), $atts );
		
		$title = sanitize_text_field( $atts['title'] );
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_html_class( $atts['visibility'] );
		
		$content = wp_kses_post( $content );
		return '<div id="rescue-tab-'. sanitize_title( $title ) .'" class="tab-content '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'"><p>'. do_shortcode( $content ) .'</p></div>';
	}
	add_shortcode( 'rescue_donation_tab', 'rescue_donation_tab_shortcode' );
}

/**
 * Donation Progress
 */
if( !function_exists('rescue_progressbar_shortcode') ) {
	function rescue_progressbar_shortcode( $atts  ) {
		$atts = shortcode_atts(array(
				'title'			=> '',
				'percentage'	=> '75',
				'color'			=> '#f1c40f',
				'class'			=> '',
				'show_percent'	=> 'true',
				'visibility'	=> 'all',
				), $atts );

		// Enque scripts
		wp_enqueue_script('rescue_progressbar');
		wp_enqueue_script('rescue_waypoints');
		
		
		
		$title = sanitize_text_field( $atts['title'] );
		$percentage = intval( $atts['percentage'] );
		$color = sanitize_text_field( $atts['color'] );
		$show_percent = boolval($atts['show_percent'] );
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_text_field( $atts['visibility'] );
		
		// Display the accordion	';
		$output = '<div class="rescue-progressbar rescue-clearfix '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'" data-percent="'. $percentage .'%">';
			if ( $title !== '' ) $output .= '<div class="rescue-progressbar-title" style="background: '. esc_attr( $color ) .';"><span>'. $title .'</span></div>';
			$output .= '<div class="rescue-progressbar-bar" style="background: '. esc_attr( $color ) .';"></div>';
			if ( $show_percent == 'true' ) {
				$output .= '<div class="rescue-progress-bar-percent">'.$percentage.'%</div>';
			}
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'rescue_progressbar', 'rescue_progressbar_shortcode' );
}

/**
 * Google Map
 */
if (! function_exists( 'rescue_shortcode_googlemaps' ) ) :
	function rescue_shortcode_googlemaps($atts, $content = null) {

		$atts = shortcode_atts(array(
				'title'			=> '',
				'location'		=> '',
				'width'			=> '',
				'height'		=> '300',
				'zoom'			=> 8,
				'align'			=> '',
				'class'			=> '',
				'visibility'	=> 'all',
				'key'			=> '',
				), $atts );

		// load scripts
		wp_enqueue_script('rescue_googlemap');
		
		$title = sanitize_text_field( $atts['title'] );
		$location = sanitize_text_field( $atts['location'] );
		$width = intval( $atts['width'] );
		$height = intval( $atts['height'] );
		$zoom = intval( $atts['zoom'] );
		$align = sanitize_html_class( $atts['align'] );
		$class = sanitize_html_class( $atts['class'] );
		$visibility = sanitize_html_class( $atts['visibility'] );
		$key = sanitize_text_field( $atts['key'] );
		
		// Load Google API key if provided. Google requires new site to use API
		$api_key = ! empty( $key ) ? '&key=' . $key : '';

		wp_enqueue_script('rescue_googlemap_api', 'https://maps.googleapis.com/maps/api/js?sensor=false' . $api_key , array('jquery'), '1.0', true );



		$output = '<div id="map_canvas_'.rand(1, 100).'" class="googlemap '. esc_attr( $class ) .' rescue-'. esc_attr( $visibility ) .'" style="height:'.$height.'px;width:100%">';
			$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
			$output .= '<input class="location" type="hidden" value="'.$location.'" />';
			$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
			$output .= '<div class="map_canvas"></div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode("rescue_googlemap", "rescue_shortcode_googlemaps");
endif;

/**
 * Font Awesome Icons
 */
if (! function_exists( 'RescueFontAwesome' ) ) :
	function RescueFontAwesome($atts) {

	    $atts = shortcode_atts(array(
	    		'type'  	=> '',
	    		'size' 		=> '',
	    		'rotate' 	=> '',
	    		'flip' 		=> '',
	    		'pull' 		=> '',
	    		'animated' 	=> '',
	    		'color' 	=> '',

	   		 	), $atts);
		
		$type = sanitize_html_class( $atts['type'] );
		$size = sanitize_html_class( $atts['size'] );
		$rotate = sanitize_html_class( $atts['rotate'] );
		$flip = sanitize_html_class( $atts['flip'] );
		$pull = sanitize_html_class( $atts['pull'] );
		$animated = sanitize_html_class( $atts['animated'] );
		$color = sanitize_text_field( $atts['color'] );

		// load scripts
		wp_enqueue_style('font_awesome');

	    $type = ($type) ? 'fa-'.$type. '' : '';
	    $size = ($size) ? 'fa-'.$size. '' : '';
	    $rotate = ($rotate) ? 'fa-rotate-'.$rotate. '' : '';
	    $flip = ($flip) ? 'fa-flip-'.$flip. '' : '';
	    $pull = ($pull) ? 'pull-'.$pull. '' : '';
	    $animated = ($animated) ? 'fa-spin' : '';
	    $color = ($color) ? ''.$color. '' : '';

	    $theAwesomeFont = '<i style="color:'. esc_attr( $color) .'" class="fa '.$type.' '.$size.' '.$rotate.' '.$flip.' '.$pull.' '.$animated.'"></i>';

	    return $theAwesomeFont;
	}

	add_shortcode('icon', 'RescueFontAwesome');
endif;

if (! function_exists( 'RescueButtonIcon' ) ) :
	function RescueButtonIcon( $atts ) {

	    $atts = shortcode_atts(array(
	    		'icon_type'  		=> '',
	    		'icon_size' 		=> '',
	    		'icon_rotate' 		=> '',
	    		'icon_flip' 		=> '',
	    		'icon_margin' 		=> '15px',
	    		'icon_animated' 	=> '',
	    		'icon_color' 		=> '',
		
	    		), $atts);
		
		$icon_type = sanitize_html_class( $atts['icon_type'] );
		$icon_size = sanitize_html_class( $atts['icon_size'] );
		$icon_rotate = sanitize_html_class( $atts['icon_rotate'] );
		$icon_flip = sanitize_html_class( $atts['icon_flip'] );
		$icon_margin = sanitize_html_class( $atts['icon_margin'] );
		$icon_animated = sanitize_html_class( $atts['icon_animated'] );
		$icon_color = sanitize_text_field( $atts['icon_color'] );
		
		// load scripts
		wp_enqueue_style('font_awesome');

	    $icon_type = ($icon_type) ? 'fa-'.$icon_type. '' : '';
	    $icon_size = ($icon_size) ? 'fa-'.$icon_size. '' : '';
	    $icon_rotate = ($icon_rotate) ? 'fa-rotate-'.$icon_rotate. '' : '';
	    $icon_flip = ($icon_flip) ? 'fa-flip-'.$icon_flip. '' : '';
	    $icon_margin = ($icon_margin) ? ''.$icon_margin. '' : '';
	    $icon_animated = ($icon_animated) ? 'fa-spin' : '';
	    $icon_color = ($icon_color) ? ''.$icon_color. '' : '';

	    $theAwesomeFont = '<i style="color:'. esc_attr( $icon_color ).'; margin-right:'.$icon_margin.'"  class="fa '.$icon_type.' '.$icon_size.' '.$icon_rotate.' '.$icon_flip.' '.$icon_pull.' '.$icon_animated.'"></i>';

	    return $theAwesomeFont;
	}
endif;

/**
 * Animation Effects
 */
if (! function_exists( 'rescue_animate_shortcode' ) ) :
	function rescue_animate_shortcode($atts, $content = null) {

	    $atts = shortcode_atts(array(
	    		'type'  	=> '',
	    		'duration' 	=> '',
	    		'delay' 	=> '',
	    		'iteration' => '',
	    		'offset' 	=> '',
		
	    		), $atts);

		$type = sanitize_html_class( $atts['type'] );
		$duration = sanitize_html_class( $atts['duration'] );
		$delay = sanitize_html_class( $atts['delay'] );
		$iteration = sanitize_html_class( $atts['iteration'] );
		$content = wp_kses_post( $content );
		
		// load scripts
		wp_enqueue_script('rescue_wow');
		wp_enqueue_script('rescue_wow_init');
		wp_enqueue_style('rescue_animate');

	    $type = ($type) ? ''.$type. '' : '';
	    $duration = ($duration) ? ''.$duration. '' : '';
	    $delay = ($delay) ? ''.$delay. '' : '';
	    $iteration = ($iteration) ? ''.$iteration. '' : '';

	    $rescue_animate = '<div class="wow '. esc_attr( $type ).'" data-wow-duration="'. esc_attr( $duration ).'" data-wow-offset="'. esc_attr( $offset ).'" data-wow-delay="'. esc_attr( $delay ).'" data-wow-iteration="'.esc_attr( $iteration ).'">' . do_shortcode($content) . '</div>';

	    return $rescue_animate;
	}

	add_shortcode('rescue_animate', 'rescue_animate_shortcode');
endif;
