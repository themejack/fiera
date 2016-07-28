<?php
/**
 * Metaboxes
 *
 * @package Fiera
 */

define( 'OMNI_BUILDER_URI', get_template_directory_uri() . '/inc/OmniBuilder' );

require 'OmniBuilder/Builder.php';

use OmniBuilder\Custom_Post_Type;
use OmniBuilder\Core_Post_Type;
use OmniBuilder\Custom_Meta_Box;
use OmniBuilder\Field\Collection;
use OmniBuilder\Field\Collection_Block;
use OmniBuilder\Field\Fieldset;
use OmniBuilder\Field\Text;
use OmniBuilder\Field\Textarea;
use OmniBuilder\Field\Checkbox;
use OmniBuilder\Field\Radio;
use OmniBuilder\Field\Select;
use OmniBuilder\Field\WP_Editor;
use OmniBuilder\Field\Hidden;
use OmniBuilder\Field\Image;
use OmniBuilder\Field\Map;

/**
 * Mapbox Public token warning message
 *
 * @param  string $msg Default message.
 * @return string
 */
function fiera_mapbox_public_token_warning_message( $msg ) {
	return sprintf( __( 'Location map is not working. You need to set your Mapbox Public Token <a href="%s">here</a>.' ), esc_url( admin_url( 'themes.php?page=fiera&tab=options' ) ) );
}
add_filter( 'omnibuilder_mapbox_public_token_warning_message', 'fiera_mapbox_public_token_warning_message', 10, 1 );

/**
 * Remove editor from front page
 */
function fiera_remove_front_page_editor() {
	$screen = get_current_screen();

	if ( 'page' === $screen->post_type ) {
		if ( isset( $_GET['post'] ) && ( $post_id = (int) $_GET['post'] ) > 0 ) {
			$front_page_id = (int) get_option( 'page_on_front' );

			if ( $post_id === $front_page_id ) {
				remove_post_type_support( 'page', 'editor' );
			}
		}
	}
}
add_action( 'load-post.php', 'fiera_remove_front_page_editor', 10, 0 );

if ( is_admin() ) {
	$ob_page = new Core_Post_Type( 'page', array(
		new Custom_Meta_Box( 'hero', 'Hero', array(
			new Image( 'background', array( 'label' => 'Background', 'preview_size' => 'large' ) ),
			new Text( 'title', array( 'label' => 'Title' ) ),
			new Text( 'info', array( 'label' => 'Info' ) ),
			new Text( 'intro', array( 'label' => 'Intro' ) ),
			new Collection( 'buttons', array( 'label' => 'Buttons' ), array(
				new Text( 'title', array( 'label' => 'Title' ) ),
				new Text( 'link', array( 'label' => 'Link' ) ),
				new Select( 'color', array(
					'label' => 'Select',
					'choices' => array(
						'red' => 'Red',
						'blue' => 'Blue',
						'green' => 'Green',
						'white' => 'White',
						'black' => 'Black',
						'transparent' => 'Transparent',
					),
				) ),
			) ),
		) ),
		new Custom_Meta_Box( 'sections', 'Sections', array(
			new Collection( 'blocks', array( 'label' => 'Sections', 'button' => 'Add Section' ), array(
				new Collection_Block( 'image_box', array( 'label' => 'Image' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new Select( 'image_position', array( 'label' => 'Image position', 'choices' => array( 'left' => 'Left', 'right' => 'Right' ) ) ),
					new Image( 'image', array( 'label' => 'Image' ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
				) ),
				new Collection_Block( 'location_box', array( 'label' => 'Location' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new Select( 'map_position', array( 'label' => 'Map position', 'choices' => array( 'left' => 'Left', 'right' => 'Right' ) ) ),
					new Map( 'map', array( 'label' => 'Map', 'mapbox_public_token' => get_option( 'fiera_mapbox_public_token' ) ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
				) ),
				new Collection_Block( 'sponsors', array( 'label' => 'Sponsors' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new Collection( 'sponsors', array( 'label' => 'Sponsors' ), array(
						new Image( 'image', array( 'label' => 'Image', 'preview_size' => 'medium' ) ),
						new Text( 'link', array( 'label' => 'Link' ) ),
					) ),
				) ),
				new Collection_Block( 'speakers', array( 'label' => 'Speakers' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
					new Collection( 'speakers', array( 'label' => 'Speakers' ), array(
						new Image( 'image', array( 'label' => 'Image' ) ),
						new Text( 'name', array( 'label' => 'Name' ) ),
						new Text( 'title', array( 'label' => 'Title' ) ),
						new Collection( 'social_icons', array( 'label' => 'Social icons' ), array(
							new Select( 'icon', array( 'label' => 'Icon', 'choices' => array( 'facebook' => 'Facebook', 'twitter' => 'Twitter', 'linkedin' => 'LinkedIn' ) ) ),
							new Text( 'link', array( 'label' => 'Link' ) ),
						) ),
					) ),
				) ),
				new Collection_Block( 'schedule', array( 'label' => 'Schedule' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
					new Collection( 'tabs', array( 'label' => 'Tabs' ), array(
						new Text( 'title', array( 'label' => 'Tab title' ) ),
						new WP_Editor( 'content', array( 'label' => 'Tab content' ) ),
					) ),
				) ),
				new Collection_Block( 'tickets', array( 'label' => 'Tickets' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
					new Collection( 'tickets', array( 'label' => 'Tickets' ), array(
						new Text( 'name', array( 'label' => 'Name' ) ),
						new WP_Editor( 'description', array( 'label' => 'Description' ) ),
						new Text( 'price', array( 'label' => 'Price' ) ),
						new Text( 'link', array( 'label' => 'Buy Now link' ) ),
					) ),
				) ),
				new Collection_Block( 'subscribe', array( 'label' => 'Subscribe' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
				) ),
				new Collection_Block( 'contact', array( 'label' => 'Contact' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
					new WP_Editor( 'form', array( 'label' => 'Form' ) ),
				) ),
				new Collection_Block( 'custom', array( 'label' => 'Custom' ), array(
					new Select( 'background_color', array(
						'label' => 'Background color',
						'choices' => array(
							'red' => 'Red',
							'green' => 'Green',
							'blue' => 'Blue',
							'light' => 'Light',
						),
						'default_value' => 'blue',
					) ),
					new Image( 'background', array( 'label' => 'Background' ) ),
					new Text( 'title', array( 'label' => 'Title' ) ),
					new Checkbox( 'add_to_menu', array( 'label' => 'Add to menu?', 'default_value' => 1 ) ),
					new WP_Editor( 'content', array( 'label' => 'Content' ) ),
					new Collection( 'buttons', array( 'label' => 'Buttons' ), array(
						new Text( 'title', array( 'label' => 'Title' ) ),
						new Text( 'link', array( 'label' => 'Link' ) ),
						new Select( 'color', array(
							'label' => 'Select',
							'choices' => array(
								'red' => 'Red',
								'blue' => 'Blue',
								'green' => 'Green',
								'white' => 'White',
								'black' => 'Black',
								'transparent' => 'Transparent',
							),
						) ),
					) ),
				) ),
			) ),
		) ),
		),
		function( $page ) {
			global $post;
			$current_id = get_the_id();
			$front_page_id = get_option( 'page_on_front' );

			return $current_id == $front_page_id;
		}
	);
}
