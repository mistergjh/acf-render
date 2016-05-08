<?php

/*
Base class for rendering ACF fields using templates
 */

class Acf_Render_Template {

  public $fields;
  public $template;

  public function __construct() {

  }

  public function render() {

    $view = $this;
    $fields = $this->fields;

    ob_start();
    include( ACF_RENDER_PLUGIN_DIR . 'templates/' . $this->template . '.php' );
    $content = ob_get_contents();
    ob_end_clean();
    return $content;

  }

  public function setFields( $fields ) {
    $this->fields = $fields;
  }

  public function getInfoTableRow( $field ) {
    $content = '';
    $content .= '<tr>';
    $content .= '<td>';
    $content .= $field->label;
    $content .= '</td>';
    $content .= '<td>';
    $content .= $field->value;
    $content .= '</td>';
    $content .= '</tr>';
    return $content;
  }

  public function getSingleField( $field ) {
    $content = '';
    $content .= '<div>';
    $content .= $field->label;
    $content .= '</div>';
    $content .= '<div>';
    $content .= $field->value;
    $content .= '</div>';
    return $content;
  }

}
