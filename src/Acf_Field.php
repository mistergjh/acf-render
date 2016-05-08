<?php

class Acf_Field_Instance {

  public $field;
  public $label;
  public $value;

  public function __construct() {

  }

  public static function make( $field, $value ) {
    $fieldInstance = new Acf_Field_Instance;
    $fieldInstance->field = $field;
    $fieldInstance->label = $field['label'];
    $fieldInstance->value = $value;
    return $fieldInstance;
  }

}
