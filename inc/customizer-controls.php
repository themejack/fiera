<?php
/**
 * Fiera Theme Customizer Controls
 *
 * @package Fiera
 * @since 1.0
 */

/**
 * Customize Layout Control Class
 *
 * @package Fiera
 * @since 1.0
 */
class Fiera_Layout_Control extends WP_Customize_Control {
	/**
	 * Type variable
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'layout';

	/**
	 * Layouts variable
	 *
	 * @access public
	 * @var array
	 */
	public $layouts;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager WP_Customize_Manager class.
	 * @param string               $id Control id.
	 * @param array                $args Control args.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->layouts = $args['layouts'];
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'fiera-customize-control-layout', get_template_directory_uri() . '/admin/css/fiera-customize-control-layout.css', array( 'customize-controls' ), '20160416', 'all' );
		wp_enqueue_script( 'fiera-customize-control-layout', get_template_directory_uri() . '/admin/js/fiera-customize-control-layout.js', array( 'customize-controls', 'jquery' ), '20160416', true );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['layouts'] = $this->layouts;
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		if ( empty( $this->layouts ) ) {
			return;
		}

		$name = '_customize-layout-' . $this->id;

		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="customize-control-content">
			<div class="radios">
			<?php
			foreach ( $this->layouts as $value => $layout ) :
				?>
				<label>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> />
					<?php echo esc_html( $layout['label'] ); ?><br/>
				</label>
				<?php
			endforeach;
			?>
			</div>
			<div class="selection"><!--
			<?php
			foreach ( $this->layouts as $value => $layout ) :
				?>
				--><div class="layout" data-value="<?php echo esc_attr( $value ); ?>">
					<div class="icon"><?php echo esc_html( $layout['label'] ); ?></div>
				</div><!--
				<?php
			endforeach;
			?>
			--></div>
		</div>
		<?php
	}
}
