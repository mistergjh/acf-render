<?php

/*
Base class for rendering ACF fields using templates
 */

class AcfRenderTemplate {

  public $key;
  public $name;
  public $field;
  public $location;
  public $filename;

  public function __construct() {

  }

  public function getTemplateName() {
    return 'text';
  }

  public function setMarkupTemplate( $markupTemplateName ) {
    $this->markupTemplate = $markupTemplateName;
  }

  public function render() {

    $view = $this;
    $fields = $this->field;

    ob_start();
    include( ACF_RENDER_PLUGIN_DIR . 'templates/' . $this->markupTemplate . '.php' );
    $content = ob_get_contents();
    ob_end_clean();
    return $content;

  }

  public function setField( $field ) {
    $this->field = $field;
  }

  public function renderFieldValueRaw( $field ) {
    print $field->value;
  }

  public function getFieldValue( $field ) {
    return $field->value;
  }

}
