<?php

class AcfRenderField {

  public $field;
  public $label;
  public $value;
  public $type;

  public function __construct() {

  }

  public static function make( $field, $value ) {
    $rf = new AcfRenderField;
    $rf->field = $field;
    $rf->type = $field['type'];
    $rf->label = $field['label'];
    $rf->value = $value;
    return $rf;
  }

}
