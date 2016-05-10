<?php

/*
* Main API, loads all other objects as needed
*/

class AcfRender {

  private $type;
  private $template;
  private $field;
  private $options;

  public function __construct( $field = false ) {
    $this->setType( 'field' );
    if( $field ) {
      $this->setField( $field );
      $this->setTemplate( 'text' );
    }
  }

  public function setType( $type ) {
    $className = 'AcfRenderType' . ucfirst( $type );
    $this->type = new $className;
  }

  public function setField( $field ) {
    $this->field = $field;
  }

  public function setTemplate( $template ) {
    $className = 'AcfRenderTemplate' . ucfirst( $template );
    require_once( ACF_RENDER_PLUGIN_DIR . 'src/templates/' . $className . '.php');

    $this->template = new $className;
    $this->template->setField( $this->field );
  }

  public function setOption( $option, $setting ) {

  }

  public function render() {
    return $this->template->render();
  }

}
