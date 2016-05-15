<?php
/*
	Plugin Name: ACF Render
	Plugin URI: http://www.goldhat.ca/plugins/acf-render
	Description: Provides a rendering engine for ACF fields
	Author: Joel Milne, GoldHat Development Group
	Version: 1.0.0
	Author URI: http://goldhat.ca
*/

define('ACF_RENDER_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('ACF_RENDER_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('ACF_RENDER_TEMPLATE_DIR', plugin_dir_path( __FILE__ ) . 'templates/');
define('ACF_RENDER_TEMPLATE_FILE_EXT', 'php');

class ACFRenderPlugin {

  public function __construct() {
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRender.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRenderType.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRenderTemplate.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/AcfRenderField.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/types/AcfRenderTypeField.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/types/AcfRenderTypeFieldGroup.php');
    add_shortcode('ACFField', array( $this, 'acfFieldShortcode'));
  }

  public function acfFieldShortcode( $params ) {

    // check if name exists
    if( !is_array( $params ) || !array_key_exists( 'name', $params )){
      return false;
    }

    // get field
    if( array_key_exists( 'post', $params )){
      $field = $this->getAcfField( $params['name'], $params['post'] );
    } else {
      $field = $this->getAcfField( $params['name'] );
    }

    // render field
    $r = new AcfRender;
    $r->setField( $field );
    $r->setTemplate( $this->selectFieldTemplate( $params ));
    return $r->render();

  }

  /*
   *
   */
  private function selectFieldTemplate( $params ) {
    $defaultFieldTemplate = 'text';
    if( array_key_exists( 'template', $params )){
      return $params['template'];
    }
    return $defaultFieldTemplate;
  }

  public function getAcfField( $fieldName, $postID ) {

    if( !$postID ) {
      global $post;
      $postID = $post->ID;
    }

    $fieldObjects = get_field_objects( $postID );
    $fieldValue = get_field( $fieldName, $postID );
    $fo = $fieldObjects[ $fieldName ];
    return AcfRenderField::make( $fo, $fieldValue );
  }

}

new ACFRenderPlugin;
