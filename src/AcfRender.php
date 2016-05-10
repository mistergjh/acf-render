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

  public function setTemplate( $templateName ) {
    $templateClassName = 'AcfRenderTemplate' . ucfirst( $templateName );
    $templatePath = ACF_RENDER_PLUGIN_DIR . 'src/templates/' . $templateClassName . '.php';

    // check if template actually exists
    if( !file_exists ( $templatePath  )) {
      $templateClassName = 'AcfRenderTemplateText';
      $templatePath = ACF_RENDER_PLUGIN_DIR . 'src/templates/' . $templateClassName . '.php';
    }

    require_once( $templatePath );

    $this->template = new $templateClassName;
    $this->template->setField( $this->field );
    $this->template->setMarkupTemplate( $templateName );
  }

  public function setOption( $option, $setting ) {

  }

  public function render() {
    return $this->template->render();
  }

}
