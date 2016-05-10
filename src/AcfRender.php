<?php

/*
* Main API, loads all other objects as needed
*/

class AcfRender {

  private $type;
  private $template;

  public function __construct() {
    $this->setType( 'field' );
    $this->setTemplate( 'text' );
  }

  public function setType( $type ) {
    $this->type = new AcfRenderType . strtoupper( $template );
  }

  public function setTemplate( $template ) {
    $this->template = new AcfRenderTemplate . strtoupper( $template );
  }

  public function setOption( $option, $setting ) {

  }

  public function render() {
    $this->template->render();
  }

}
