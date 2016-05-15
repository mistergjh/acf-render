<?php

/*
* Main API, loads all other objects as needed
*/

class AcfRender {

  private $type;
  private $template;
  private $field;
  private $options;

  public function __construct( $field = false ) {
    $this->setType( 'field' );
    if( $field ) {
      $this->setField( $field );
      $this->setTemplate( 'text' );
    }
    $this->registerTemplates();
  }

  public function setType( $type ) {
    $className = 'AcfRenderType' . ucfirst( $type );
    $this->type = new $className;
  }

  public function setField( $field ) {
    $this->field = $field;
  }

  private function registerTemplates() {
    $this->templateRegistry = array(
      'checkbox' => array(
        'field_types'     => array('checkbox'),
      ),
      'choice' => array(
        'field_types'     => array('checkbox, select, boolean, true_false'),
      ),
      'color' => array(
        'field_types'     => array('color'),
      ),
      'date' => array(
        'field_types'     => array('date'),
      ),
      'date' => array(
        'field_types'     => array('date'),
      ),
      'html' => array(
        'field_types'     => array('html'),
      ),
      'image' => array(
        'field_types'     => array('image'),
      ),
      'number' => array(
        'field_types'     => array('number'),
      ),
      'page' => array(
        'field_types'     => array('page_object'),
      ),
      'page_link' => array(
        'field_types'     => array('page_link'),
      ),
      'post_object' => array(
        'field_types'     => array('post_object'),
      ),
      'select' => array(
        'field_types'     => array('select'),
      ),
      'select' => array(
        'field_types'     => array('select'),
      ),
      'text' => array(
        'field_types'     => array('text'),
      ),
      'true_false' => array(
        'field_types'     => array('true_false'),
      ),
      'url' => array(
        'field_types'     => array('url'),
      ),
    );
    return apply_filters( 'acf-render-template-register', $this->templateRegistry );
  }

  public function getRegisteredTemplates() {
    return $this->templateRegistry;
  }

  public function setTemplate( $templateName ) {
    $templateClassName = 'AcfRenderTemplate' . ucfirst( $templateName );
    $templatePath = ACF_RENDER_PLUGIN_DIR . 'src/templates/' . $templateClassName . '.php';

    // check if template actually exists
    if( !file_exists ( $templatePath  )) {
      $templateClassName = 'AcfRenderTemplateText';
      $templatePath = ACF_RENDER_PLUGIN_DIR . 'src/templates/' . $templateClassName . '.php';
    }

    require_once( $templatePath );

    $this->template = new $templateClassName;
    $this->template->setField( $this->field );
    $this->template->setMarkupTemplate( $templateName );
  }

  public function setOption( $option, $setting ) {

  }

  public function render() {
    return $this->template->render();
  }

}
