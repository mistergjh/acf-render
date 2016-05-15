<?php

/*
 * File template
 */

class AcfRenderTemplateFile extends AcfRenderTemplate {

  public $url;
  public $name;

  public function setField( $field ) {
    $this->field = $field;
    $this->url = $field->field['value']['url'];
    $this->name = $field->field['value']['filename'];
  }

  public function getUrl() {
    return $this->url;
  }

  public function getName() {
    return $this->name;
  }

}
