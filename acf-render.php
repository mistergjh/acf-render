<?php
/*
	Plugin Name: ACF Render
	Plugin URI: http://goldhat.ca/plugins/acf-render/
	Description: Provides a rendering engine for ACF fields
	Author: Joel Milne, GoldHat Development Group
	Version: 1.1.0
	Author URI: http://goldhat.ca
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
    if( array_key_exists( 'post', $params )) {
      $r->setField( $params['name'], $params['post'] );
    } else {
      $r->setField( $params['name'] );
    }

    // set template
    $r->setTemplateByParams( $params );

    // show label
    if( array_key_exists( 'show_label', $params )) {
      if( $params['show_label'] ) {
        $r->setShowLabel();
      }
    }

    var_dump($r);

    return $r->render();

  }

}

new ACFRenderPlugin;
