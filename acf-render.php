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
    $rt = new Acf_Render_Template;
    $group = $this->getAcfGroupByTitle( $params['name'] );
    $fields = $this->getAcfFieldsByGroup( $group['key'] );
    $rt->setFields( $fields );
    $rt->template = 'info-table';
    return $rt->render();
  }

  public function acfFieldShortcode( $params ) {
    $group = $this->getAcfGroupByTitle( "Property Basics" );
    $rt = new Acf_Render_Template;
    $field = $this->getAcfField( $params['name'] );
    $rt->setFields( $field );
    $rt->template = 'single-field';
    return $rt->render();
  }

  public function getAcfGroupByTitle( $title ) {
    $post = get_page_by_title( $title, OBJECT, "acf-field-group" );
    $group = _acf_get_field_group_by_key( $post->post_name );
    if( $group ) {
      return $group;
    }
    return false;
  }

  public function getAcfField( $fieldName ) {
    global $post;
    $fieldObjects = get_field_objects();
    $fieldValue = get_field( $fieldName, $post->ID );
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
