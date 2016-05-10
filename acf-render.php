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

class ACFRender {

  public function __construct() {
    require( ACF_RENDER_PLUGIN_DIR . 'src/Acf_Field.php');
    require( ACF_RENDER_PLUGIN_DIR . 'src/Acf_Render_Template.php');
    add_shortcode('ACFGroup', array( $this, 'acfGroupShortcode'));
    add_shortcode('ACFField', array( $this, 'acfFieldShortcode'));
  }

  public function acfGroupShortcode( $params ) {

    // check if name exists
    if( !is_array( $params ) || !array_key_exists( 'name', $params )){
      return false;
    }

    $rt = new Acf_Render_Template;
    $group = $this->getAcfGroupByTitle( $params['name'] );
    $fields = $this->getAcfFieldsByGroup( $group['key'] );
    $rt->setFields( $fields );
    $rt->template = 'info-table';
    return $rt->render();
  }

  public function acfFieldShortcode( $params ) {

    // check if name exists
    if( !is_array( $params ) || !array_key_exists( 'name', $params )){
      return false;
    }

    // get field render object
    if( array_key_exists( 'post', $params )){
      $field = $this->getAcfField( $params['name'], $params['post'] );
    } else {
      $field = $this->getAcfField( $params['name'] );
    }

    $rt = new Acf_Render_Template;
    $rt->setFields( $field );


    $rt->template = $this->selectFieldTemplate( $params );
    return $rt->render();
  }

  /*
   *
   * TO DO:
   * - check if template actually exists
   * -
   */
  private function selectFieldTemplate( $params ) {
    $defaultFieldTemplate = 'single-field';
    if( array_key_exists( 'template', $params )){
      return $params['template'];
    }
    return $defaultFieldTemplate;
  }

  public function getAcfGroupByTitle( $title ) {
    $post = get_page_by_title( $title, OBJECT, "acf-field-group" );
    $group = _acf_get_field_group_by_key( $post->post_name );
    if( $group ) {
      return $group;
    }
    return false;
  }

  public function getAcfField( $fieldName, $postID ) {

    if( !$postID ) {
      global $post;
      $postID = $post->ID;
    }

    $fieldObjects = get_field_objects( $postID );
    $fieldValue = get_field( $fieldName, $postID );
    $fo = $fieldObjects[ $fieldName ];
    return Acf_Field_Instance::make( $fo, $fieldValue );
  }

  public function getAcfFieldsByGroup( $groupID ) {
    $groupFields = acf_get_fields( $groupID );
    $postFields = get_fields();
    $fieldsInGroup = array();
    foreach( $groupFields as $gf ) {
      $fieldName = $gf['name']; // this is the field name being test such as "bedrooms"
      if( array_key_exists( $fieldName, $postFields)) {
        $fieldsInGroup[] = Acf_Field_Instance::make( $gf, $postFields[ $fieldName ] );
      }
    }
    return $fieldsInGroup;
  }

}

new ACFRender;


/*

Shortcode Field outputs just the field data
  Optional renderingEngine adds prefix/suffix code

 */
