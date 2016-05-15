<?php

/*
 * Image template
 */

class AcfRenderTemplateImage extends AcfRenderTemplate {

  public $src;
  public $alt;
  public $sizes;

  public function setField( $field ) {
    $this->field = $field;
    $this->src = $field->field['value']['url'];
    $this->alt = $field->field['value']['alt'];
  }

  public function getSrc() {
    return $this->src;
  }

  public function getAlt() {
    return $this->alt;
  }

}
