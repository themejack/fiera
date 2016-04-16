<?php
/**
 * Fiera Theme Customizer extra functions
 *
 * @package Fiera
 * @since 1.0
 */

/**
 * Fiera Sanitize select
 */
class Fiera_Sanitize_Select {
	/**
	 * Select keys
	 *
	 * @var array
	 */
	public $keys;

	/**
	 * Default value
	 *
	 * @var array|string
	 */
	public $default_value;

	/**
	 * Fiera Sanitize Select constructor
	 *
	 * @param array  $keys          Keys that will be sanitized.
	 * @param string $default_value Default value.
	 */
	public function Fiera_Sanitize_Select( $keys, $default_value = '' ) {
		$this->keys = $keys;
		$this->default_value = $default_value;
	}

	/**
	 * Sanitize callback
	 *
	 * @param  string $value Selected value.
	 * @return string
	 */
	public function callback( $value ) {
		if ( ! in_array( $value, $this->keys ) ) {
			return $this->default_value;
		}

		return $value;
	}
}
