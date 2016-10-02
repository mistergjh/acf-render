<?php

/*
Base class for rendering ACF fields using templates
 */

class AcfRenderTemplate {

  public $key;
  public $name;
  public $location;
  public $filename;
  public $singleFile = false; // is template a single file or directory
  public $params = array();
  private $field = false;

  public function __construct() {

  }

  public function getTemplateName() {
    return $this->name;
  }

  public function showLabel() {
    return $this->label;
  }

  private function getTemplateFilePath() {
    if( $this->singleFile ) {
      return $this->location . $this->filename . '.php';
    }
    return $this->location . $this->key . '/' . $this->filename . '.php';
  }

  public function render() {

    $template = $this;
    $this->parseGlobalParams();
    $this->parseParams();
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
    $this->field =  $field;
  }

  public function renderFieldValueRaw() {
    print $this->field->value;
  }

  public function getFieldValue() {
    return $this->field->value;
  }

  public function getLabel() {
    return $this->field->label;
  }

  public function parseGlobalParams() {
    $this->parseParamLabel();
  }

  // override parseParams in template classes to handle custom params
  public function parseParams() {}

  public function parseParamLabel() {
    if( array_key_exists('label', $this->params)) {
      $this->label = $this->params['label'];
    } else {
      $this->label = false;
    }
  }

}
