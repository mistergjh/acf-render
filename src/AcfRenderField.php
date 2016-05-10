<?php

class AcfRenderField {

  public $field;
  public $label;
  public $value;

  public function __construct() {

  }

  public static function make( $field, $value ) {
    $rf = new AcfRenderField;
    $rf->field = $field;
    $rf->label = $field['label'];
    $rf->value = $value;
    return $rf;
  }

}
