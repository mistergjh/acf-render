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

  private function getRegisteredTemplates() {
    return $this->templateRegistry;
  }

  private function loadTemplate( $templateKey ) {
    $templateSettings = $this->getTemplateSettings( $templateKey );
    return $this->initTemplate( $templateKey, $templateSettings );
  }

  public function getTemplateSettings( $templateKey ) {
    $templateRegistry = $this->getRegisteredTemplates();
    $templateSettings = $templateRegistry[$templateKey];
    $templateSettings['key'] = $templateKey; // add key so it's available later
    return $templateSettings;
  }

  private function templateNameFromKey( $templateKey ) {
    $name = ucwords( $templateKey );
    return str_replace('_', ' ', $name);
  }

  private function templateClassNameFromKey( $templateKey ) {
    $className = ucwords( $templateKey );
    $className = str_replace('_', '', $className);
    $className = 'AcfRenderTemplate' . $className;
    return $className;
  }

  private function templateLocation( $templateSettings ) {
    if( key_exists('location', $templateSettings) ) {
      return $templateSettings['location'];
    }
    return ACF_RENDER_TEMPLATE_DIR;
  }

  private function includeTemplateClassFile( $templatePath ) {
    // check if template class file exists
    if( !file_exists ( $templatePath  )) {
      $templateClassName = 'AcfRenderTemplateDefault';
      $templatePath = ACF_RENDER_TEMPLATE_DIR . 'default/' . $templateClassName . '.php';
    }
    require_once( $templatePath );
  }

  private function templateName( $templateSettings ) {
    if( key_exists('name', $templateSettings) ) {
      return $templateSettings['name'];
    }
    return $this->templateNameFromKey( $templateSettings['key'] );
  }

  private function templateFilename( $templateSettings ) {
    if( key_exists('filename', $templateSettings) ) {
      return $templateSettings['filename'];
    }
    return $templateSettings['key'];
  }

  private function initTemplate( $templateKey, $templateSettings ) {
    $templateClassName = $this->templateClassNameFromKey( $templateKey );
    $templatePath = $this->templateLocation( $templateSettings ) . $templateKey . '/' . $templateClassName . '.php';
    $this->includeTemplateClassFile( $templatePath );
    $template = new $templateClassName;
    $template->key = $templateKey;
    $template->location = $this->templateLocation( $templateSettings );
    $template->name = $this->templateName( $templateSettings );
    $template->filename = $this->templateFilename( $templateSettings );

    var_dump( $template );
    die();

    return $template;
  }

  public function setTemplateFilename() {

  }

  public function setTemplate( $templateKey ) {
    $this->template = $this->loadTemplate( $templateKey );
    $this->template->setField( $this->field );

    var_dump( $this->template );
    die();


  }

  public function setOption( $option, $setting ) {

  }

  public function render() {
    return $this->template->render();
  }

}
