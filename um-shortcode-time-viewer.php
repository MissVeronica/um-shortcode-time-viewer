<?php
/**
 * Plugin Name:     Ultimate Member - Shortcode Time Viewer
 * Description:     Extension to Ultimate Member for different date and time view formats.
 * Version:         1.0.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.6.10
 */

 if ( ! defined( 'ABSPATH' ) ) exit; 
 if ( ! class_exists( 'UM' ) ) return;
 
 class UM_Shortcode_Time_Viewer {

    function __construct() {

        add_shortcode( 'um_time_view', array( $this, 'um_time_view_shortcode' ));
    }

    public function um_time_view_shortcode( $atts, $content ) {

        if ( is_array( $atts ) && isset( $atts['meta_key'] )) {

            $meta_value = um_user( sanitize_text_field( $atts['meta_key'] ));
            $time_view = '';

            if ( ! empty( $meta_value )) {

                if ( is_numeric( $meta_value )) {                
                    $unix_time = $meta_value;

                } else {

                    $unix_time = false;
                    if ( is_string( $meta_value )) {
                        $unix_time = strtotime( $meta_value );
                    }
                }

                if ( ! empty( $unix_time )) {

                    $format = strtolower( trim( sanitize_text_field( $atts['format'] )));

                    switch( $format ) {

                        case 'human':   $diff    = abs( current_time( 'timestamp' ) - $unix_time );
                                        $years   = floor(  $diff / YEAR_IN_SECONDS);
                                        $months  = floor(( $diff - $years * YEAR_IN_SECONDS ) / MONTH_IN_SECONDS );
                                        $days    = floor(( $diff - $years * YEAR_IN_SECONDS - $months * MONTH_IN_SECONDS ) / DAY_IN_SECONDS );
                                        $hours   = floor(( $diff - $years * YEAR_IN_SECONDS - $months * MONTH_IN_SECONDS - $days * DAY_IN_SECONDS ) / HOUR_IN_SECONDS );
                                        $minutes = floor(( $diff - $years * YEAR_IN_SECONDS - $months * MONTH_IN_SECONDS - $days * DAY_IN_SECONDS - $hours * HOUR_IN_SECONDS) / MINUTE_IN_SECONDS );
                                        $seconds = floor(( $diff - $years * YEAR_IN_SECONDS - $months * MONTH_IN_SECONDS - $days * DAY_IN_SECONDS - $hours * HOUR_IN_SECONDS - $minutes * MINUTE_IN_SECONDS ));
                                        
                                        $time_view = array();
                                        if ( ! empty( $years ))  $time_view[] = ( $years > 1 )  ? sprintf( __( '%s years',  'ultimate-member' ), $years )  : sprintf( __( '%s year',  'ultimate-member' ), $years );
                                        if ( ! empty( $months )) $time_view[] = ( $months > 1 ) ? sprintf( __( '%s months', 'ultimate-member' ), $months ) : sprintf( __( '%s monts', 'ultimate-member' ), $months );
                                        if ( ! empty( $days ))   $time_view[] = ( $days > 1 )   ? sprintf( __( '%s days',   'ultimate-member' ), $days )   : sprintf( __( '%s das',   'ultimate-member' ), $days );

                                        if ( count( $time_view ) == 0 ) {
                                            if ( ! empty( $hours ))   $time_view[] = ( $hours > 1 )   ? sprintf( __( '%s hours', 'ultimate-member' ), $hours )     : sprintf( __( '%s hour', 'ultimate-member' ), $hours );
                                            if ( ! empty( $minutes )) $time_view[] = ( $minutes > 1 ) ? sprintf( __( '%s minutes', 'ultimate-member' ), $minutes ) : sprintf( __( '%s minute', 'ultimate-member' ), $minutes );
                                        }

                                        if ( count( $time_view ) == 0 ) {
                                            if ( ! empty( $seconds)) $time_view[] = ( $seconds > 1 ) ? sprintf( __( '%s seconds', 'ultimate-member' ), $seconds ) : sprintf( __( '%s second', 'ultimate-member' ), $seconds );
                                        }

                                        $time_view = implode( ', ', $time_view );
                                        $pos = strrpos( $time_view, ', ' );

                                        if ( $pos !== false ) {
                                            $time_view = substr_replace( $time_view, __( ' and ', 'ultimate-member' ), $pos, 2 );
                                        }
                                        break;
                
                        case 'wp1':     $time_view = date_i18n( get_option( 'date_format' ), $unix_time );
                                        break;
                                        
                        case 'wp2':     $time_view = date_i18n( get_option( 'time_format' ), $unix_time );
                                        break;

                        case 'wp3':     $time_view = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $unix_time );
                                        break;
                                        
                        case 'custom':  $time_view = date_i18n( sanitize_text_field( $atts['custom'] ), $unix_time );
                                        break;

                        default:        $time_view = 'format?';
                                        break;

                    }

                    if ( ! empty( $content )) {
                        $time_view = sprintf( sanitize_text_field( $content ), $time_view );
                    }
                }
            } 

            return esc_attr( $time_view );

        } else return 'Shortcode parameter error';
    }
}

new UM_Shortcode_Time_Viewer();
