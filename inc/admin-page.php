<?php
/**
 * Fiera admin page
 *
 * @package Fiera
 */

/** Load WordPress dashboard API */
require_once( ABSPATH . 'wp-admin/includes/dashboard.php' );

/**
 * Displays all messages
 */
function fiera_admin_page_notices() {
	settings_errors( 'fiera' );

	$fiera_mapbox_public_token = trim( get_option( 'fiera_mapbox_public_token' ) );

	if ( empty( $fiera_mapbox_public_token ) ) : ?>
	<div class="notice notice-error is-dismissible">
		<p><?php echo wp_kses( sprintf( __( '<strong>Fiera:</strong> location map is not working. You need to set your Mapbox Public Token <a href="%s">here</a>.' ), esc_url( admin_url( 'themes.php?page=fiera&tab=options' ) ) ), array( 'a' => array( 'href' => array() ), 'strong' => array() ) ); ?></p>
	</div>
	<?php endif;
}
add_action( 'admin_notices', 'fiera_admin_page_notices' );

/**
 * Mapbox public token field
 */
function fiera_mapbox_public_token_field() {
?>
<input type="text" name="fiera_mapbox_public_token" id="fiera_mapbox_public_token" placeholder="<?php esc_attr_e( 'Insert your Mapbox Public Token here', 'fiera' ); ?>" value="<?php echo esc_attr( get_option( 'fiera_mapbox_public_token' ) ); ?>" class="regular-text" />
<p class="description" id="fiera_mapbox_public_token-description"><?php printf( wp_kses( __( 'You need a public API token to access the Mapbox static API. You can get it <a href="%s" target="_blank">here</a>. <a href="%s" target="_blank">Help?</a>', 'fiera' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.mapbox.com/studio/account/tokens', 'https://www.mapbox.com/help/create-api-access-token' ); ?></p>
<?php
}

/**
 * Theme options
 */
function fiera_theme_options_fields() {
	add_settings_section( 'fiera-options', 'Theme options', null, 'fiera' );

	add_settings_field( 'fiera_mapbox_public_token', 'Mapbox Public Token', 'fiera_mapbox_public_token_field', 'fiera', 'fiera-options' );
	register_setting( 'fiera-options', 'fiera_mapbox_public_token' );
}
add_action( 'admin_init', 'fiera_theme_options_fields' );

/**
 * Welcome metabox
 */
function fiera_welcome_metabox() {
	?>
	<p>Glad to see you here. To start you can read our introduction blog post <a href="http://slicejack.com/blog" target="_blank">here</a>. If you are looking for documentation you can find it on <a href="https://github.com/themejack/fiera" target="_blank">Github</a>, also our code is very well documented.</p>
	<?php
}

/**
 * Customize metabox
 */
function fiera_customize_metabox() {
	$homepage = get_post( get_option( 'page_on_front' ) );
	$homepage_link = __( 'homepage', 'fiera' );

	if ( ! empty( $homepage ) && ! is_wp_error( $homepage ) ) {
		$homepage_link = '<a href="' . esc_url( get_edit_post_link( $homepage->ID ) ) . '">' . esc_html( $homepage_link ) . '</a>';
	}
	?>
	<p>Theme customization never been easier. We prepared a plenty of options for each section on <?php echo wp_kses( $homepage_link, array( 'a' => array( 'href' => array() ) ) ); ?>. Want to customize general options? Try <a href="<?php echo esc_url( add_query_arg( array( 'return' => urlencode( 'themes.php/?page=fiera' ) ), admin_url( '/customize.php' ) ) ); ?>">customizer</a>.</p>
<?php
}

/**
 * Child theme metabox
 */
function fiera_child_theme_metabox() {
	?>
	<p>Want to make more customizations? We prepared child theme for you. Fork it on <a href="https://github.com/themejack/fiera-child" target="_blank">GitHub</a> and create custom child theme.</p>
<?php
}

/**
 * Translation metabox
 */
function fiera_translation_metabox() {
	?>
	<p>You can use <code>languages/fiera.pot</code> file to create a new translations. Please share your translations, create a <a href="https://github.com/themejack/fiera/pulls" target="_blank">pull request</a>.</p>
<?php
}

/**
 * Delete dashboard cached rss widget
 *
 * @param  string $widget_id Widget ID.
 */
function fiera_delete_dashboard_cached_rss_widget( $widget_id ) {
	$locale = get_locale();
	$cache_key = 'dash_' . md5( $widget_id . '_' . $locale );

	delete_transient( $cache_key );
}

/**
 * SliceJack News dashboard widget.
 *
 * @since 1.0
 */
function sj_dashboard_widget() {
?>
	<div class="news-actions">
		<a href="<?php echo esc_url( admin_url( 'themes.php?page=fiera&reload_news=1' ) ); ?>" title="<?php esc_attr_e( 'Reload cache', 'fiera' ); ?>" class="reload-cache"><span class="dashicons dashicons-update"></span></a>
	</div>
<?php
	$feed = array(
		'type' => '',
		'link' => 'http://slicejack.com',
		'url' => 'http://slicejack.com/?feed=rss2',
		'title' => __( 'SliceJack Blog', 'briar' ),
		'items' => 5,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1,
	);

	define( 'DOING_AJAX', true );

	wp_dashboard_cached_rss_widget( 'dashboard_slicejack', 'sj_dashboard_widget_output', $feed );
}

/**
 * Display the SliceJack news feed.
 *
 * @since 1.0
 *
 * @param string $widget_id Widget ID.
 * @param array  $feed     Array of informations about RSS feed.
 */
function sj_dashboard_widget_output( $widget_id, $feed ) {
?>
	<div class="rss-widget">
		<?php sj_widget_rss_output( $feed['url'], $feed ); ?>
		<div style="display: block; text-align: center; margin-top: 30px;">
			<a href="<?php echo esc_url( 'http://slicejack.com/blog/' ); ?>" style="display: inline-block; width: 150px; height: 32px; line-height: 32px; color: #777; border: solid 1px #777; border-radius: 2px; text-align: center; text-decoration: none; font-size: 13px;"><?php esc_html_e( 'Read more posts', 'briar' ) ?></a>
		</div>
	</div>
	<?php
}

/**
 * Display the RSS entries in a list.
 *
 * @since 2.5.0
 *
 * @param string|array|object $rss RSS url.
 * @param array               $args Widget arguments.
 */
function sj_widget_rss_output( $rss, $args = array() ) {
	if ( is_string( $rss ) ) {
		$rss = fetch_feed( $rss );
	} elseif ( is_array( $rss ) && isset( $rss['url'] ) ) {
		$args = $rss;
		$rss = fetch_feed( $rss['url'] );
	} elseif ( ! is_object( $rss ) ) {
		return;
	}

	if ( is_wp_error( $rss ) ) {
		if ( is_admin() || current_user_can( 'manage_options' ) ) {
			echo '<p>' . wp_kses( sprintf( __( '<strong>RSS Error</strong>: %s', 'briar' ), $rss->get_error_message() ), array( 'strong' => array() ) ) . '</p>';
		}
		return;
	}

	$default_args = array( 'show_author' => 0, 'show_date' => 0, 'show_summary' => 0, 'items' => 0 );
	$args = wp_parse_args( $args, $default_args );

	$items = (int) $args['items'];
	if ( $items < 1 || 20 < $items ) {
		$items = 10;
	}
	$show_summary  = (int) $args['show_summary'];
	$show_author   = (int) $args['show_author'];
	$show_date     = (int) $args['show_date'];

	if ( ! $rss->get_item_quantity() ) {
		echo '<ul><li>' . esc_html__( 'An error has occurred, which probably means the feed is down. Try again later.', 'briar' ) . '</li></ul>';
		$rss->__destruct();
		unset( $rss );
		return;
	}

	echo '<ul>';
	foreach ( $rss->get_items( 0, $items ) as $item ) {
		$link = $item->get_link();
		while ( stristr( $link, 'http' ) != $link ) {
			$link = substr( $link, 1 );
		}
		$link = esc_url( strip_tags( $link ) );

		$title = esc_html( trim( strip_tags( $item->get_title() ) ) );
		if ( empty( $title ) ) {
			$title = __( 'Untitled', 'briar' );
		}

		$desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
		$desc = esc_attr( wp_trim_words( $desc, 55, ' [&hellip;]' ) );

		$summary = '';
		if ( $show_summary ) {
			$summary = $desc;

			// Change existing [...] to [&hellip;].
			if ( '[...]' == substr( $summary, -5 ) ) {
				$summary = substr( $summary, 0, -5 ) . '[&hellip;]';
			}

			$summary = '<div class="rssSummary">' . esc_html( $summary ) . '</div>';
		}

		$date = '';
		if ( $show_date ) {
			$date = $item->get_date( 'U' );

			if ( $date ) {
				$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
			}
		}

		$author = '';
		if ( $show_author ) {
			$author = $item->get_author();
			if ( is_object( $author ) ) {
				$author = $author->get_name();
				$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
			}
		}

		$read_more = '';
		if ( '' !== $link ) {
			$read_more = '<a href="' . $link . '" style="display: inline-block; width: 105px; height: 22px; line-height: 22px; color: #777; border: solid 1px #777; border-radius: 2px; text-align: center; text-decoration: none; margin-top: 10px; font-size: 11px;">' . __( 'Read more', 'briar' ) . '</a>';
		}

		if ( '' === $link ) {
			echo "<li>$title{$date}{$summary}{$author}</li>"; // WPCS: xss ok.
		} elseif ( $show_summary ) {
			echo "<li><a class='rsswidget' href='$link'>$title</a>{$date}{$summary}{$author}{$read_more}</li>"; // WPCS: xss ok.
		} else {
			echo "<li><a class='rsswidget' href='$link'>$title</a>{$date}{$author}{$read_more}</li>"; // WPCS: xss ok.
		}
	}
	echo '</ul>';
	$rss->__destruct();
	unset( $rss );
}

/**
 * Contribute metabox
 */
function fiera_contribute_metabox() {
	?>
	<p>Found a bug? Create a <a href="https://github.com/themejack/fiera/issues" target="_blank">new issue</a>.<br />Want to resolve an issue or create a new feature? Make a <a href="https://github.com/themejack/fiera/pulls" target="_blank">pull request</a>.<br />For everything else <a href="https://github.com/themejack/fiera" target="_blank">Github</a>.</p>
	<?php
}

/**
 * Fiera admin page
 */
function fiera_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
	}

	$tabs = array( 'welcome', 'options' );

	$tab = '';
	if ( isset( $_GET['tab'] ) ) {
		$tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
	}

	if ( ! in_array( $tab, $tabs ) ) {
		$tab = 'welcome';
	}

	if ( isset( $_GET['reload_news'] ) && 1 === (int) $_GET['reload_news'] ) {
		fiera_delete_dashboard_cached_rss_widget( 'dashboard_slicejack' );
		?>
		<script type="text/javascript">
			window.location = '<?php echo esc_url( admin_url( 'themes.php?page=fiera' ) ); ?>';
		</script>
		<?php // Add anchore for situations when javascript is disabled. ?>
		<div class="wrap">
			<a href="<?php echo esc_url( admin_url( 'themes.php?page=fiera' ) ); ?>"><?php esc_html_e( 'Click here', 'fiera' ); ?></a>
		</div>
		<?php
		die();
	}

	wp_enqueue_style( 'fiera-admin-page', get_template_directory_uri() . '/admin/css/fiera-admin-page.css', array(), '1.0.0', 'all' );

	if ( 'welcome' === $tab ) {
		$screen = get_current_screen();

		wp_enqueue_script( 'dashboard' );

		add_meta_box( 'fiera_welcome', __( 'Welcome', 'fiera' ), 'fiera_welcome_metabox', $screen->id, 'normal' );
		add_meta_box( 'fiera_customize', __( 'Customize', 'fiera' ), 'fiera_customize_metabox', $screen->id, 'normal' );
		add_meta_box( 'fiera_child_theme', __( 'Child theme', 'fiera' ), 'fiera_child_theme_metabox', $screen->id, 'normal' );
		add_meta_box( 'fiera_contribute', __( 'Contribute to Fiera', 'fiera' ), 'fiera_contribute_metabox', $screen->id, 'normal' );
		add_meta_box( 'fiera_translation', __( 'Translations', 'fiera' ), 'fiera_translation_metabox', $screen->id, 'normal' );
		add_meta_box( 'dashboard_slicejack', __( 'Slicejack News', 'fiera' ), 'sj_dashboard_widget', $screen->id, 'side', 'high' );
	}
	?>
	<div class="wrap" id="fiera-wrap">
		<h1 class="page-title"><?php esc_html_e( 'Fiera', 'fiera' ); ?> <sup class="version">1.0.0</sup></h1>
		<div class="tabs">
			<ul>
				<li<?php if ( 'welcome' === $tab ) : ?> class="active"<?php endif; ?>><a href="<?php echo esc_url( admin_url( 'themes.php?page=fiera' ) ); ?>" class="dashboard"><?php esc_html_e( 'Dashboard' ); ?></a></li>
				<li<?php if ( 'options' === $tab ) : ?> class="active"<?php endif; ?>><a href="<?php echo esc_url( admin_url( 'themes.php?page=fiera&tab=options' ) ); ?>" class="options"><?php esc_html_e( 'Options' ); ?></a></li>
			</ul>
		</div>
		<?php if ( 'welcome' === $tab ) : ?>
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder columns-2">
				<div id="postbox-container-1" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'normal', '' ); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'side', '' ); ?>
				</div>
			</div>
		</div>
		<?php
		wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
		wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
		?>
		<?php elseif ( 'options' === $tab ) : ?>
			<?php settings_errors(); ?>
			<form action="options.php" method="POST">
				<?php
				settings_fields( 'fiera-options' );
				do_settings_sections( 'fiera' );
				submit_button();
				?>
			</form>
		<?php endif; ?>
		<div class="page-footer">
			<div class="developer">
				<a href="<?php echo esc_url( 'http://slicejack.com' ); ?>" target="_blank"><img src="data:image/png;base64,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" /></a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Add menu page
 */
function fiera_admin_page_menu() {
	add_theme_page( 'Fiera', 'Fiera', 'manage_options', 'fiera', 'fiera_admin_page' );
}
add_action( 'admin_menu', 'fiera_admin_page_menu' );
