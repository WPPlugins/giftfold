<?php
/*
Plugin Name: GiftFold
Plugin URI: http://www.giftfold.com
Description: This plugin adds a widget to take donations using GiftFold.
Version: 1.1.0
Author: Jonathan Berglund
Author URI: http://about.me/jlberglund
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class giftfold_widget extends WP_Widget {
  // constructor
  function __construct() {
    parent::__construct(
      'giftfold_widget', // Base ID
      'GiftFold', // Name
      array( 'description' => __( 'A simple donation form which integrates w/ GiftFold.' ), ) // Args
    );
  }

  // widget form creation
  function form($instance) {
    if( isset( $instance[ 'title' ] ) ) {
      $title = $instance['title'];
    } else {
      $title = __( 'Donate Now', 'giftfold_widget' );
    }

    if( isset( $instance[ 'url' ] ) ) {
      $url = $instance['url'];
    } else {
      $url = __( 'https://subdomain.giftfold.com', 'giftfold_widget' );
    }

    if( isset( $instance[ 'label' ] ) ) {
      $label = $instance['label'];
    } else {
      $label = __( '$', 'giftfold_widget' );
    }

    if( isset( $instance[ 'default_amount' ] ) ) {
      $default_amount = $instance['default_amount'];
    } else {
      $default_amount = __( '0.00', 'giftfold_widget' );
    }

    if( isset( $instance[ 'cross_domain' ] ) ) {
      $cross_domain = $instance['cross_domain'];
    } else {
      $cross_domain = __( '0', 'giftfold_widget' );
    }

    if( isset( $instance[ 'submit' ] ) ) {
      $submit = $instance['submit'];
    } else {
      $submit = __( 'Donate', 'giftfold_widget' );
    }
    ?>
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'giftfold_widget' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:', 'giftfold_widget' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Amount Label:', 'giftfold_widget' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'default_amount' ); ?>"><?php _e( 'Default Amount:', 'giftfold_widget' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'default_amount' ); ?>" name="<?php echo $this->get_field_name( 'default_amount' ); ?>" type="text" value="<?php echo esc_attr( $default_amount ); ?>" />
</p>

<p>
  <input class="checkbox" id="<?php echo $this->get_field_id( 'cross_domain' ); ?>" name="<?php echo $this->get_field_name( 'cross_domain' ); ?>" type="checkbox" value="1" <?php echo ( esc_attr( $cross_domain ) == '1' ? 'checked="checked"' : '' ); ?> />
  <label for="<?php echo $this->get_field_id( 'cross_domain' ); ?>"><?php _e( 'Google Analytics asynchronous, cross-domain tracking?', 'giftfold_widget' ); ?></label>
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'submit' ); ?>"><?php _e( 'Button Label:', 'giftfold_widget' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'submit' ); ?>" name="<?php echo $this->get_field_name( 'submit' ); ?>" type="text" value="<?php echo esc_attr( $submit ); ?>" />
</p>
    <?php
  }

  // widget update
  function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
    $instance['label'] = ( ! empty( $new_instance['label'] ) ) ? strip_tags( $new_instance['label'] ) : '';
    $instance['default_amount'] = ( ! empty( $new_instance['default_amount'] ) ) ? strip_tags( $new_instance['default_amount'] ) : '';
    $instance['cross_domain'] = ( ! empty( $new_instance['cross_domain'] ) ) ? strip_tags( $new_instance['cross_domain'] ) : '';
    $instance['submit'] = ( ! empty( $new_instance['submit'] ) ) ? strip_tags( $new_instance['submit'] ) : '';

    return $instance;
  }

  // widget display
  function widget($args, $instance) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $url = $instance['url'];
    $label = $instance['label'];
    $default_amount = $instance['default_amount'];
    $cross_domain = ( $instance['cross_domain'] == 1 ? "onsubmit=\"_gaq.push(['_linkByPost', this, true]);\"" : "" );
    $submit = $instance['submit'];

    echo $args['before_widget'];

    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];
    echo '<form method="get" action="'.$url.'" id="giftfold-widget-form" '.$cross_domain.'>
      <label for="giftfold-widget-amount-input" id="giftfold-widget-amount-label">'.$label.'</label>
      <input id="giftfold-widget-amount-input" name="donation[amount]" size="6" type="text" value="'.$default_amount.'" />
      <input id="giftfold-widget-submit" type="submit" value="'.$submit.'" />
      </form>';
    echo $args['after_widget'];
  }
}

function register_giftfold_widget() {
  register_widget( 'giftfold_widget' );
}
add_action( 'widgets_init', 'register_giftfold_widget' );
?>
