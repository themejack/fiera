<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Fiera
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fiera_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'fiera_body_classes' );

/**
 * Collect front page data
 *
 * @return array
 */
function fiera_collect_frontpage_data() {
	$id = false;

	if ( is_front_page() ) {
		$id = get_the_id();
	} else {
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$id = get_option( 'page_on_front' );
		}
	}

	if ( empty( $id ) ) {
		return array();
	}

	return array(
		'hero' => array(
			'background' => wp_get_attachment_image_src( (int) get_post_meta( $id, '_hero_background', true ), 'full' ),
			'title' => esc_html( get_post_meta( $id, '_hero_title', true ) ),
			'info' => esc_html( get_post_meta( $id, '_hero_info', true ) ),
			'intro' => esc_html( get_post_meta( $id, '_hero_intro', true ) ),
			'buttons' => fiera_esc_buttons_data( get_post_meta( $id, '_hero_buttons', true ) ),
		),
		'sections' => fiera_esc_sections( get_post_meta( $id, '_sections_blocks', true ) ),
	);
}

/**
 * Set global data
 */
function fiera_set_global_data() {
	if ( ! isset( $GLOBALS['fiera_data'] ) ) {
		$GLOBALS['fiera_data'] = fiera_collect_frontpage_data();
	}
}
add_action( 'init', 'fiera_set_global_data' );

/**
 * Escape buttons data
 *
 * @param  array $data Data to escape.
 * @return array       Escaped data.
 */
function fiera_esc_buttons_data( $data = array() ) {
	$allowed_colors = array( 'red', 'blue', 'green', 'white', 'black', 'transparent' );
	foreach ( $data as $key => $item ) {
		if ( empty( $item ) || ! isset( $item['link'] ) ) {
			unset( $data[ $key ] );
		}

		if ( isset( $item['title'] ) ) {
			$data[ $key ]['title'] = esc_html( $item['title'] );
		}

		$data[ $key ]['link'] = esc_url( $item['link'] );
		$data[ $key ]['color'] = isset( $item['color'] ) && in_array( $item['color'], $allowed_colors ) ? $item['color'] : $allowed_colors[0];
	}

	return $data;
}

/**
 * Escape sections
 *
 * @param  array $data Data to escape.
 * @return array        Escaped data.
 */
function fiera_esc_sections( $data = array() ) {
	if ( ! is_array( $data ) ) {
		return array(
			'blocks' => array(),
			'nav_items' => array(),
		);
	}

	$nav_items = array();

	foreach ( $data as $key => $section ) {
		// Prepare image box.
		if ( isset( $section['type'] ) && 'image_box' === $section['type'] ) {
			$data[ $key ]['image'] = wp_get_attachment_image_src( $section['image'], 'full' );
		}

		// Prepare sponsors.
		if ( isset( $section['type'] ) && 'sponsors' === $section['type'] ) {
			if ( isset( $section['sponsors'] ) && ! empty( $section['sponsors'] ) ) {
				foreach ( $section['sponsors'] as $sponsor_id => $sponsor ) {
					$data[ $key ]['sponsors'][ $sponsor_id ]['image'] = wp_get_attachment_image( $sponsor['image'], 'full' );
				}
			} else {
				$data[ $key ]['sponsors'] = array();
			}
		}

		// Prepare speakers.
		if ( isset( $section['type'] ) && 'speakers' === $section['type'] ) {
			if ( isset( $section['speakers'] ) && ! empty( $section['speakers'] ) ) {
				foreach ( $section['speakers'] as $speaker_id => $speaker ) {
					$data[ $key ]['speakers'][ $speaker_id ]['image'] = wp_get_attachment_image_src( $speaker['image'], 'full' );

					if ( isset( $speaker['social_icons'] ) && ! empty( $speaker['social_icons'] ) ) {
						foreach ( $speaker['social_icons'] as $social_icon_id => $social_icon ) {
							if ( ! in_array( $social_icon['icon'], array( 'facebook', 'twitter', 'linkedin' ) ) ) {
								unset( $data[ $key ]['speakers'][ $speaker_id ]['social_icons'][ $social_icon_id ] );
							} else {
								$data[ $key ]['speakers'][ $speaker_id ]['social_icons'][ $social_icon_id ]['link'] = esc_url( $social_icon['link'] );
							}
						}
					} else {
						$data[ $key ]['speakers'][ $speaker_id ]['social_icons'] = array();
					}
				}
			} else {
				$data[ $key ]['speakers'] = array();
			}
		}

		// Prepare schedule.
		if ( isset( $section['type'] ) && 'schedule' === $section['type'] ) {
			if ( isset( $section['tabs'] ) && ! empty( $section['tabs'] ) ) {
				$is_first = true;
				foreach ( $section['tabs'] as $tab_id => $tab ) {
					if ( ! empty( trim( $tab['title'] ) ) ) {
						$data[ $key ]['tabs'][ $tab_id ]['is_active'] = $is_first;
						if ( $is_first ) {
							$is_first = false;
						}

						$data[ $key ]['tabs'][ $tab_id ]['title'] = trim( $tab['title'] );
					}
				}
			} else {
				$data[ $key ]['tabs'] = array();
			}
		}

		// Prepare contact.
		if ( isset( $section['type'] ) && 'contact' === $section['type'] ) {
			if ( ! isset( $section['form'] ) ) {
				$data[ $key ]['form'] = array();
			}
		}

		// Prepare tickets.
		if ( isset( $section['type'] ) && 'tickets' === $section['type'] ) {
			if ( ! isset( $section['tickets'] ) ) {
				$data[ $key ]['tickets'] = array();
			}
		}

		// Prepare custom section.
		if ( isset( $section['type'] ) && 'custom' === $section['type'] ) {
			if ( ! isset( $section['buttons'] ) ) {
				$data[ $key ]['buttons'] = array();
			} else {
				$data[ $key ]['buttons'] = fiera_esc_buttons_data( $section['buttons'] );
			}
		}

		// Prepare background.
		if ( isset( $section['background'] ) ) {
			$data[ $key ]['background'] = wp_get_attachment_image_src( $section['background'], 'full' );
		}

		// Prepare background color.
		if ( isset( $section['background_color'] ) ) {
			if ( ! in_array( $section['background_color'], array( 'red', 'green', 'blue', 'light' ) ) ) {
				$section['background_color'] = 'blue';
			}
		}

		// Check add to menu? and generate nav items.
		if ( isset( $section['add_to_menu'] ) && '1' === $section['add_to_menu'] && isset( $section['title'] ) && ! empty( $section['title'] ) ) {
			$slug = preg_replace( '/[^0-9a-z]/i', '_', trim( strtolower( $section['title'] ) ) );

			if ( empty( $slug ) ) {
				$slug = $key;
			}

			if ( ! ctype_alnum( substr( $slug, 0, 1 ) ) ) {
				$slug = 's_' . $slug;
			}

			$i = 1;
			while ( array_key_exists( $slug, $nav_items ) ) {
				if ( $i > 1 ) {
					$slug = substr( $slug, -( strlen( $i ) + 1 ) );
				}

				$i++;
				$slug .= '_' . $i;
			}

			$data[ $key ]['slug'] = $slug;
			$nav_items[ $slug ] = $section['title'];
		}
	}

	$data = array(
		'blocks' => $data,
		'nav_items' => $nav_items,
	);

	return $data;
}

/**
 * Setup block data
 *
 * @param  array $_block New block data.
 * @return boolean
 */
function setup_block_data( $_block = array() ) {
	if ( is_array( $_block ) && ! empty( $_block ) && isset( $_block['type'] ) ) {
		global $block;
		$block = $_block;

		return true;
	}

	return false;
}

/**
 * Returns sidebar position
 *
 * @since 1.0
 *
 * @return string 'none', 'left' or 'right'
 */
function fiera_get_layout() {
	$global_layout = get_theme_mod( 'fiera_global_layout', 'left' );
	$blog_layout = get_theme_mod( 'fiera_blog_layout', 'disabled' );
	$single_layout = get_theme_mod( 'fiera_single_layout', 'disabled' );
	$archive_layout = get_theme_mod( 'fiera_archive_layout', 'disabled' );
	$category_archive_layout = get_theme_mod( 'fiera_category_archive_layout', 'disabled' );
	$search_layout = get_theme_mod( 'fiera_search_layout', 'disabled' );
	$page_404_layout = get_theme_mod( 'fiera_404_layout', 'disabled' );
	$page_layout = get_theme_mod( 'fiera_page_layout', 'disabled' );

	$accepted_layouts = array( 'none', 'left', 'right' );

	$layout = '';

	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
		$layout = 'none';
	}

	if ( is_home() ) {
		$layout = $blog_layout;
	}

	if ( is_archive() ) {
		$layout = $archive_layout;
	}

	if ( is_category() ) {
		$layout = $category_archive_layout;
	}

	if ( is_search() ) {
		$layout = $search_layout;
	}

	if ( is_404() ) {
		$layout = $page_404_layout;
	}

	if ( is_single() ) {
		$layout = $single_layout;
	}

	if ( is_page() ) {
		$layout = $page_layout;
	}

	if ( ! in_array( $layout, $accepted_layouts ) ) {
		$layout = $global_layout;
	}

	return $layout;
}

/**
 * Main classes
 *
 * @param  array   $classes Array of classes that will be extended.
 * @param  boolean $echo    Echo or not.
 * @return array|null       If $echo is true than nothing will be returned else if $classes variable is empty array null will be returned else array of classes will be returned.
 */
function fiera_main_classes( $classes = array(), $echo = true ) {
	$layout = fiera_get_layout();

	if ( is_customize_preview() ) {
		$classes[] = 'col-md-12';
		$classes[] = 'fiera-main-class';
	} else {
		if ( 'none' === $layout ) {
			$classes[] = 'col-md-12';
		} else {
			$classes[] = 'col-md-8';

			if ( 'left' === $layout ) {
				$classes[] = 'col-md-push-4';
			}
		}
	}

	if ( true === $echo ) {
		echo ' class="' . esc_attr( join( ' ', $classes ) ) . '"';
	} else {
		if ( empty( $classes ) ) {
			return null;
		} else {
			return $classes;
		}
	}
}

/**
 * Sidebar classes
 *
 * @param  array   $classes Array of classes that will be extended.
 * @param  boolean $echo    Echo or not.
 * @return array|null       If $echo is true than nothing will be returned else if $classes variable is empty array null will be returned else array of classes will be returned.
 */
function fiera_sidebar_classes( $classes = array(), $echo = true ) {
	$layout = fiera_get_layout();

	if ( is_customize_preview() ) {
		$classes[] = 'col-md-4';
		$classes[] = 'fiera-sidebar-class';
	} else {
		if ( 'none' !== $layout ) {
			$classes[] = 'col-md-4';

			if ( 'left' === $layout ) {
				$classes[] = 'col-md-pull-8';
			}
		}
	}

	if ( true === $echo ) {
		echo ' class="' . esc_attr( join( ' ', $classes ) ) . '"';
	} else {
		if ( empty( $classes ) ) {
			return null;
		} else {
			return $classes;
		}
	}
}
