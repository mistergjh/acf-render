<?php
/*
	Plugin Name: ACF Render
	Plugin URI: http://goldhat.ca/plugins/acf-render/
	Description: Provides a rendering engine for ACF fields
	Author: Joel Milne, GoldHat Development Group
	Version: 1.1.0
	Author URI: http://goldhat.ca/
  Text Domain: acf-render
  License: GPLv2 or later
*/

define('ACF_RENDER_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('ACF_RENDER_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('ACF_RENDER_TEMPLATE_DIR', plugin_dir_path( __FILE__ ) . 'templates/');

class ACFRenderPlugin {

  public function __construct() {
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRender.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRenderTemplate.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRenderField.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRenderTemplateDetect.php');
    new AcfRenderTemplateDetect;
    add_shortcode('acf-render', array( $this, 'acfRenderShortcode'));
  }

  public function acfRenderShortcode( $params ) {
    // check if name exists
    if( !is_array( $params ) || !array_key_exists( 'name', $params )){
      return false;
    }
    // render field
    $r = new AcfRender;
    $r->setParams( $params );
    return $r->render();
  }

}

new ACFRenderPlugin;
