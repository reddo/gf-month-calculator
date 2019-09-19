<?php
/*
Plugin Name: Gravity Forms Month Calculator Field Add-On
Plugin URI: http://www.gravityforms.com
Description: An addon to add mont calculator fields to Gravity Forms
Version: 1.0.1
Author: reddo
Author URI: http://birdcreation.com
Text Domain: gf-month-calculator
Domain Path: /languages/
Original Author: Rocketgenius (http://www.rocketgenius.com)
GitHub Plugin URI: https://github.com/reddo/gf-month-calculator

------------------------------------------------------------------------
Copyright 2012-2016 Rocketgenius Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

define( 'GF_SIMPLE_FIELD_ADDON_VERSION', '1.0' );

add_action( 'gform_loaded', array( 'GF_Month_Calculator_Field_AddOn', 'load' ), 5 );

class GF_Month_Calculator_Field_AddOn {

    public static function load() {

        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }

        require_once( 'class-gf-month-calculator.php' );

        GFAddOn::register( 'GFMonthCalculatorFieldAddOn' );
    }

}