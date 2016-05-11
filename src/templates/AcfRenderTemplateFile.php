<?php

/*
 * File template
 */

class AcfRenderTemplateFile extends AcfRenderTemplate {

  public $url;
  public $filename;

  public function setField( $field ) {
    $this->field = $field;
    $this->url = $field->field['value']['url'];
    $this->filename = $field->field['value']['filename'];
  }

  public function getUrl() {
    return $this->url;
  }

  public function getFilename() {
    return $this->filename;
  }

}
