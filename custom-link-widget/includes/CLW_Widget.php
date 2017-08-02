<?php

class CLWWidget extends WP_Widget {
	private $fields;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$fields = [ 'title', 'link', 'classes' ];

		$this->setFields( $fields );

		$widget_ops = [
			'classname'   => 'CLW_Widget',
			'description' => 'Custom link widget',
		];
		parent::__construct( 'clw_widget', 'CLW Widget', $widget_ops );
	}

	/**
	 * helper function
	 *
	 * @param $instance
	 * @param $field
	 *
	 * @return string
	 */
	private function prepare_form_fields( $instance ) {
		$fields_names = $this->getFields();
		$fields       = [];

		foreach ( $fields_names as $name ) {
			$fields[ $name ] = ! empty( $instance[ $name ] ) ? $instance[ $name ] : esc_html__( 'New ' . $name, 'clw' );
		}

		return $fields;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$fields = $this->prepare_form_fields( $instance );

		if ( ! empty( $fields ) && is_array( $fields ) ) {
			foreach ( $fields as $field_id => $field_value ) {
				?>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( $field_id ) ); ?>">
						<?php esc_attr_e( ucfirst( $field_id ), 'clw' ); ?>
                    </label>
                    <input class="widefat"
                           id="<?php echo esc_attr( $this->get_field_id( $field_id ) ); ?>"
                           name="<?php echo esc_attr( $this->get_field_name( $field_id ) ); ?>"
                           type="text"
                           value="<?php echo esc_attr( $field_value ); ?>">
                </p>
				<?php
			}
		}
	}

	/**
	 * Helper function
	 *
	 * @param $instance
	 * @param $field
	 *
	 * @return string
	 */
	private function prepare_update_field( $instance, $field ) {
		return ! empty( $instance[ $field ] ) ? strip_tags( $instance[ $field ] ) : '';
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$fields_names = $this->getFields();
		$instance     = [];

		if ( ! empty( $fields_names ) && is_array( $fields_names ) ) {
			foreach ( $fields_names as $field_id ) {
				$instance[ $field_id ] = $this->prepare_update_field( $new_instance, $field_id );
			}
		}

		return $instance;
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$base_url = get_site_url();
		$instance = apply_filters('clw_instance', $instance );

		require( __DIR__ . '/templates/CLW_Template.php' );
	}

	/**
	 * @return mixed
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * @param mixed $fields
	 */
	public function setFields( $fields ) {
		$this->fields = $fields;
	}
}