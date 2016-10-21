<?php

/*
* Main API, loads all other objects as needed
*/

class AcfRender {

  private $type;
  private $post;
  private $template;
  private $field;
  private $params;
  private $registeredTemplates;

  public function __construct( $field = false ) {
    if( $field ) {
      $this->setField( $field );
      $this->setTemplate( 'text' );
    }
    $this->registeredTemplates = $this->registerTemplates();
  }

  public function setPostByParams() {
    if( array_key_exists( 'post', $this->params )) {
      $this->post = $this->params['post'];
    }
  }

  public function setParams( $params ) {
    $this->params = $params;
    $this->setPostByParams();
    $this->setFieldByParams();
    $this->setTemplateByParams();
  }

  public function setFieldByParams() {
    if( array_key_exists( 'post', $this->params )) {
      $this->setField( $this->params['name'], $this->params['post'] );
    } else {
      $this->setField( $this->params['name'] );
    }
  }

  public function setField( $fieldName, $postID = false ) {

    if( !$postID ) {
      global $post;
      $postID = $post->ID;
    }

    $fieldObjects = get_field_objects( $postID );
    $fieldValue = get_field( $fieldName, $postID );
    $fo = $fieldObjects[ $fieldName ];
    $this->field = AcfRenderField::make( $fo, $fieldValue );

    return $this->field;
  }

  public function getRegisteredTemplates() {
    return $this->registeredTemplates;
  }

  private function isTemplateRegistered( $template ) {
    $tr = $this->getRegisteredTemplates();
    if( key_exists( $template, $tr ) ) {
      return true;
    }
    return false;
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

  public function loadTemplate( $templateKey ) {
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
      return WP_CONTENT_DIR . '/' . $templateSettings['location'];
    }
    return ACF_RENDER_TEMPLATE_DIR;
  }

  private function includeTemplateClassFile( $templatePath ) {
    if( file_exists ( $templatePath  )) {
      require_once( $templatePath );
      return true;
    }
    return false;
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
    $singleFile = false;

    if( !$this->includeTemplateClassFile( $templatePath )) {
      $templateClassName = 'AcfRenderTemplateDefault';
      $templatePath = ACF_RENDER_TEMPLATE_DIR . 'default/' . $templateClassName . '.php';
      $this->includeTemplateClassFile( $templatePath );
      $singleFile = true;
    }

    $template = new $templateClassName;
    $template->key = $templateKey;
    $template->location = $this->templateLocation( $templateSettings );
    $template->name = $this->templateName( $templateSettings );
    $template->filename = $this->templateFilename( $templateSettings );
    $template->singleFile = $singleFile;
    $template->params = $this->loadTemplateParams();
    return $template;
  }

  public function loadTemplateParams() {
    unset( $this->params['name'] );
    unset( $this->params['post'] );
    unset( $this->params['template'] );
    return $this->params;
  }

  public function setTemplateByParams() {
    if( array_key_exists( 'template', $this->params )) {
      $this->setTemplate( $this->params['template'] );
    } else {
      $this->setTemplateAuto();
    }
  }

  public function setTemplate( $templateKey ) {
    $this->template = $this->loadTemplate( $templateKey );
    $this->template->setField( $this->field );
  }

  private function setTemplateAuto() {
    if( $this->isTemplateRegistered( $this->field->type ) ) {
      $this->setTemplate( $this->field->type );
    } else {
      $this->setTemplate( 'default' );
    }
  }

  public function render() {
    return $this->template->render();
  }

}
