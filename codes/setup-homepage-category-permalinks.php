<?php

/* ----------------------------------------------------------------------------
 * HOME PAGE CATEGORY PERMALINKS
 * To avoid manually adding the URL for the Categories found on the homepage
 * ------------------------------------------------------------------------- */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// SHORTCODE
add_shortcode( 'setup-categ-permalink', 'setup_category_permalink' );
function setup_category_permalink( $atts ) {

	if( is_array( $atts ) ){

		// CLASS (ANCHOR)
		if( array_key_exists( "class", $atts ) ) {
			$class = 'class="'.$atts[ "class" ].'"';
		}

		// CLASS (CONTAINER)
		if( array_key_exists( "wrapper_class", $atts ) ) {
			$wrapper_class = 'class="'.$atts[ "wrapper_class" ].'"';
		}

		// CONTAINER
		if( array_key_exists( "wrapper", $atts ) ) {
			$wrapper = $atts[ "wrapper" ];
		}

		// TEXT
		if( array_key_exists( "text", $atts ) ) {
			$text = $atts[ "text" ];
		} else {
			$text = '';
		}

		// SLUG
        if( array_key_exists( "slug", $atts ) ) {

            $slug = $atts[ 'slug' ];

			if( is_numeric( $slug ) ) {
				//echo 'TRUE';	
				// $slug used might be the category ID
				$catid = get_term_by( 'id', $slug, 'category' );
				
				$catid_id = $catid->term_taxonomy_id;

				// check if $text is specified
				if( empty( $text ) ) {
					$text = strtoupper( $catid->name );
				}

				if( !empty( $catid_id ) ) {

					$return = '<a href="'.get_category_link( $catid_id ).'" '.$class.'>'.$text.'</a>';

				}

			} else {

				$categ_obj = get_category_by_slug( $slug );

				if( empty( $text ) ) {
					$text = $categ_obj->name;
				}
				
				$return = '<strong><a href="'.get_category_link( $categ_obj->term_id ).'" '.$class.'>'.$text.'</a></strong>';
				
			}

        }
        
    }

    // output
    if( $return ) {

    	if( $wrapper == 'div' ) {

    		return '<div '.$wrapper_class.'>'.$return.'</div>';

    	} elseif( $wrapper == 'span' ) {

    		return '<span '.$wrapper_class.'>'.$return.'</span>';

    	} elseif( $wrapper == 'p' ) {

    		return '<p '.$wrapper_class.'>'.$return.'</p>';

    	} else {

    		return $return;

    	}

    }

}