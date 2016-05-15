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
  public $singleFile = false; // is template a single file or directory

  public function __construct() {

  }

  public function getTemplateName() {
    return 'text';
  }

  private function getTemplateFilePath() {
    if( $this->singleFile ) {
      return $this->location . $this->filename . '.php';
    }
    return $this->location . $this->key . '/' . $this->filename . '.php';
  }

  public function render() {

    $view = $this;
    $fields = $this->field;

    if( !file_exists( $this->getTemplateFilePath() )) {
      return 'Invalid template name. Template not found.';
    }

    ob_start();
    include( $this->getTemplateFilePath() );
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
