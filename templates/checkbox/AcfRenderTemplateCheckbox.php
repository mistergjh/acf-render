<?php

/*
 * Checkbox template
 */

class AcfRenderTemplateCheckbox extends AcfRenderTemplate {

  public $emptyMessage = 'No value selected.';

  public function parseParams() {
    if( array_key_exists('empty', $this->params)) {
      $this->emptyMessage = $this->params['empty'];
    }
  }

}
